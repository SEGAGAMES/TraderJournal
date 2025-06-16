<?php
// Обновление одного элемента в users.
session_start();

include_once("../config/database.php");
include_once("../config/helper.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'PUT')
{
    // Проверка на наличие пустых значений.
    if (Helper::isnoOneNull($_PUT['newlogin'],$_PUT['login'], $_PUT['password'], $_PUT['role'], $_PUT['surname'], $_PUT['name'], $_PUT['lastname'], $_PUT['email']))
    {
        http_response_code(400);
        echo null;
        die();
    }
    $newlogin = $_PUT['newlogin'];
    $login = $_PUT['login'];
    $password = $_PUT['password'];
    $role = $_PUT['role'];
    $surname = $_PUT['surname'];
    $name = $_PUT['name'];
    $lastname = $_PUT['lastname'];
    $email = $_PUT['email'];

    // Проверка прав пользователя.
    if ($_SESSION['priority'] <= 8)
    {
        http_response_code(403);
        echo null;
        die();
    }

    $query = "INSERT INTO users `login`, `password`, `role`, `surname`, `name`, `lastname`, `email` VALUES (?,?,?,?,?,?,?) WHERE `login` = ?;";
    $result = $db->SendQuery($query, [$newlogin, $password, $role, $surname, $name, $lastname, $email, $login]);

    // Проверка на доступность сервиса.
    if (!$result)
    {
        http_response_code(503);
        echo null;
        die();
    }
    http_response_code(202);
    echo null;
    die();
}
else
{
    http_response_code(405);
    echo null;
    die();
}

?>