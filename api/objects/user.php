<?php
ini_set('display_errors', 0);

require_once("../config/database.php");
require_once("../config/helper.php");


class User
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
        $query = "SELECT * FROM `users` WHERE 1";
        return self::$db->SendQuery($query);
    }

    // Считывание одного пользователя.
    public static function ReadOne($username)
    {
        self::init();
        $query = "SELECT * FROM `users` WHERE username = '$username'";
        return self::$db->SendQuery($query);
    }

    // Обновление данных пользователя.
    public static function Update($username, $password="", $role ="")
    {
        if(Helper::IsNoOneNull([$password, $role]))
        {
            self::init();
            if (!empty($password))
                $updates[] = "`password` = '$password'";
            
            if (!empty($role))
                $updates[] = "`role` = '$role'";
            
            $query= "UPDATE `users` SET ";
            $query .= implode(', ', $updates);
            $query .= " WHERE username = '$username'";
            return self::$db->SendQuery($query);
        }
        else
            return false;
    }

    // Создание пользователя.
    public static function Create($username, $password, $role)
    {
        if (!(Helper::IsNull([$username, $password, $role])))
        {
            self::init();
            $query="INSERT INTO `users` (`username`, `password`, `role`) VALUES ('$username','$password','$role')";
            return self::$db->SendQuery($query);
        }
        else
            return false;
    }

    // Удаление пользовател по его имени.
    public static function Delete($username)
    {
        self::init();
        $query="DELETE FROM `users` WHERE username = '$username'";
        return self::$db->SendQuery($query);
    }
}
?>
