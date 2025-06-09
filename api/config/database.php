<?php

// Работа с базой данных.
class Database
{
    public function __construct()
    {
        $this->Connect();
    }
    // Адрес размещения сервера базы данных.
    private $host = "localhost";

    // Название базы данных.
    private $db_name = "trades";

    // Имя пользования для подключения.
    private $username = "root";

    // Пароль для подклчюения.
    private $password = "mysql";

    // Подключение к базе данных.
    private $conn;

    // Соединение с базой.
    public function Connect()
    {
        try
        {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        }
        catch (PDOException $exception)
        {
            echo "Ошибка подключения: " . $exception->getMessage();
        }
    }

    // Обновление поля host.
    public function SetHost($newHost)
    {
        $this->host=$newHost;
    }

    // Отправка запроса в базу данных.
    public function SendQuery($query)
    {
        try 
        {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt;
        }
        catch (PDOException $e)
        {
            return false;
        }
    }
}
?>