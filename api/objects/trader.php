<?php
ini_set('display_errors', 0);

require_once("../config/database.php");
require_once("../config/helper.php");

class Trader
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

    // Считывание всех пользователей.
    public static function Read()
    {
        self::init();
        $query = "SELECT * FROM `traders` WHERE 1";
        return self::$db->SendQuery($query);
    }

    // Считывание одного пользователя.
    public static function ReadOne($username)
    {
        self::init();
        $query = "SELECT * FROM `traders` WHERE username = '$username'";
        return self::$db->SendQuery($query);
    }

    // Обновление данных трейдера.
    public static function Update($username, $last='', $name='', $sur='')
    {
        self::init();
        if(Helper::IsNoOneNull([$last, $name, $sur]))
        {
            if (!empty($last))
                $updates[] = "`last` = '" . $last . "'";

            if (!empty($name))
                $updates[] = "`name` = '" . $name . "'";
            
            if (!empty($sur))
                $updates[] = "`sur` = '" . $sur . "'";
            
            $query="UPDATE `traders` SET ";
            $query .= implode(', ', $updates);
            $query .= " WHERE `username` = '$username'";
            return self::$db->SendQuery($query);
        }
        else
            return false;
    }

    // Создание нового трейдера.
    public static function Create($username, $last, $name, $sur)
    {
        self::init();
        if (!(Helper::IsNull([$username, $last, $name, $sur])))
        {
            self::init();
            $query="INSERT INTO `traders` (`last`, `name`, `sur`, `username`) VALUES ('$last','$name','$sur', '$username')";
            return self::$db->SendQuery($query);
        }
        else
            return false;
    }
}
?>
