<?php

require_once("../congig/database.php");
require_once("../congig/helper.php");

// Класс сделки.
class Trade
{
    // База данных.
    static private $db = new Database();
    
    // Установка хоста для базы данных.
    static public function SetHost($newHost)
    {
        self::$db->SetHost($newHost);
    }

    // Получение количества сделок для пользователей.
    function Count($username)
    {
        $query = "SELECT COUNT(*) FROM tradings t WHERE t.username = '$username'";
        return self::$db->SendQuery($query);
    }

    // Получить сделки указанные пользователем, с заданным offset.
    function Read($page, $username)
    {
        $query = "SELECT * FROM tradings t WHERE t.username ='$username' ORDER BY t.id LIMIT 10 OFFSET $page";
        return self::$db->SendQuery($query);
    }

    // Получить все сделки пользователя.
    function Readall($username)
    {
        $query = "SELECT * FROM tradings t JOIN `stocks` s on t.ticker = s.ticker WHERE t.username ='$username' ORDER BY t.id";
        return self::$db->SendQuery($query);
    }

    // Получить данные по одной сделке.
    function ReadOne($id)
    {
        $query = "SELECT * FROM `tradings` JOIN `stocks` s on `tradings`.ticker = s.ticker WHERE tradings.id = $id";
        return self::$db->SendQuery($query);
    }

    // Обновление данных сделки
    function Update($id, $deal_type, $path, $cost, $count, $date, $time, $ticker)
    {
        if(Helper::IsNoOneNull([]))
        {
            if (!empty($deal_type))
                $updates[] = "`deal_type` = '$deal_type'";
            if (!empty($path))
                $updates[] = "`photo_path` = '$path'";
            if (!empty($cost))
                $updates[] = "`cost` = '$cost'";
            if (!empty($ticker))
                $updates[] = "`ticker` = '$ticker'";
            if (!empty($count))
                $updates[] = "`count` = '$count'";
            if (!empty($date))
                $updates[] = "`date` = '$date'";
            if (!empty($time))
                $updates[] = "`time` = '$time'";

            $query="UPDATE `tradings` SET ";
            $query .= implode(', ', $updates);
            $query .= " WHERE id =$id";
            return self::$db->SendQuery($query);
        }
        else
            return false;
    }
    function create()
    {
        try
        {
            $availableID = file_get_contents('http://localhost/КР/api/trade/readall.php');
            $data = json_decode($availableID, true);
            $existingIds = array_column($data, 'id');

            $missingId = 1;
            while (in_array($missingId, $existingIds)) {
                $missingId++;
            }
            $this->id = $missingId;
            $querys = array();
            for ($i = 0; $i<count($this->traders);$i++)
            {
                $query2 ="
                INSERT INTO `trade_trader`
                    (`trade_id`, `trader_id`)
                VALUES
                    (" . $this->id . ", ". $this->traders[$i] .")
                ";
                array_push($querys, $query2);
            }
            $this->ticker = json_decode(file_get_contents('http://localhost/КР/api/stock/search.php?ticker=' . $this->ticker), true)[0]['id'];
            $query="
                INSERT INTO `tradings`
                    (`id`, `ticker`, `deal_type`, `cost`, `futures`, `count`, `date`, `time`, `photo_path`)
                VALUES
                    (?,?,?,?,?,?,?,?,?)";

            try
            {
                if (DateTime::createFromFormat('d.m.Y', $this->date))
                    $this->date = DateTime::createFromFormat('d.m.Y', $this->date)->format('Y-m-d');
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $this->id);
                $stmt->bindParam(2, $this->ticker);
                $stmt->bindParam(3, $this->deal_type);
                $stmt->bindParam(4, $this->cost);
                $stmt->bindParam(5, $this->futures);
                $stmt->bindParam(6, $this->count);
                $stmt->bindParam(7, $this->date);
                $stmt->bindParam(8, $this->time);
                $stmt->bindParam(9, $this->path);
                $stmt->execute();
                for ($i = 0; $i<count($this->traders);$i++)
                {
                    $stmt = $this->conn->prepare($querys[$i]);
                    $stmt->execute();
                }
                return true;
            }
            catch (PDOException $e)
            {
                return false;
            }
        }
        catch (Exception $e)
        {
            return $e;
        }

    }

    function delete()
    {
        try
        {
            $query="DELETE FROM `tradings` WHERE id = ?";
            try
            {
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(1, $this->id);
                $stmt->execute();
                return true;
            }
            catch (PDOException $e) 
            {
                return false;
            }
        }
        catch (Exception $e)
        {
            return $e;
        }
    }
}
?>
