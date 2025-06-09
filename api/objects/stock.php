<?php

require_once("../config/database.php");
require_once("../config/helper.php");

// Работа со сделками.
class Stock
{
    // База данных.
    static private $db;
    
    // Инициализация базы данных.
    public static function init() {
        if (self::$db === null) {
            self::$db = new Database();
        }
        return self::$db;
    }

    // Изменяет хост для подключения базы данных.
    static public function SetDbHost($newDbHost)
    {
        self::init();
        self::db->SetHost($newDbHost);
    }

    // Считывает все элементы из базы данных.
    static public function Read()
    {
        self::init();
        $query = "SELECT * FROM `stocks` WHERE 1";

        return self::$db->SendQuery($query);
    }

    // Выполняет поиск элемента в базе данных по заданному параметру.
    static public function ReadOne($ticker)
    {
        self::init();
        $query = "SELECT * FROM `stocks` WHERE ticker = '$ticker'";
        return self::$db->SendQuery($query);
    }

    // Выполняет обновление элемента в базе данных по заданным параметрам.
    static public function Update($ticker, $futures="", $exchange="")
    {
        self::init();
        if(Helper::IsNoOneNull([$futures, $exchange]))
        {
            if ($futures == "0" or !empty($futures))
                $updates[] = "`futures` = '" . $futures . "'";

            if (!empty($exchange))
                $updates[] = "`exchange` = '" . $exchange . "'";

            $query="UPDATE `stocks` SET ";
            $query .= implode(', ', $updates);
            $query .= " WHERE ticker = '$ticker'";
            return self::$db->SendQuery($query);
        }
        else
            return false;
    }

    // Создает элемент в базе данных по заданным парметрам - должны быть не нулевые.
    static public function Create($ticker, $futures, $exchange)
    {
        self::init();
        if (!(Helper::isNull([$ticker, $futures, $exchange])))
        {
            $query="INSERT INTO `stocks` (`ticker`, `futures`, `exchange`) VALUES ('$ticker','$futures','$exchange')";
            return self::$db->SendQuery($query);
        }
        else
            return false;
    }

    // Удаляет элемент из базы по заданному параметру id.
    static public function Delete($ticker)
    {
        self::init();
        $query="DELETE FROM `stocks` WHERE ticker = '$ticker'";
        return self::$db->SendQuery($query);
    }
}
?>
