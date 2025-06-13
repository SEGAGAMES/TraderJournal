<?php
// Обновление одного элемента в users.

include_once("../config/database.php");
include_once("../config/helper.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'PUT')
{
    // Проверка на наличие пустых значений.
    if (Helper::isnoOneNull($_PUT['newlogin'],$_PUT['login'], $_PUT['password'], $_PUT['role'], $_PUT['surname'], $_PUT['name'], $_PUT['lastname'], $_PUT['email'], $_PUT['priority'], $_PUT['userPriority']))
    {
        http_response_code(400);
        return null;
    }
    $newlogin = $_PUT['newlogin'];
    $login = $_PUT['login'];
    $password = $_PUT['password'];
    $role = $_PUT['role'];
    $surname = $_PUT['surname'];
    $name = $_PUT['name'];
    $lastname = $_PUT['lastname'];
    $email = $_PUT['email'];
    $priority = $_PUT['priority'];
    $userPriority = $_PUT['userPriority'];

    // Проверка прав пользователя.
    if ($userPriority <= $priority)
    {
        http_response_code(403);
        return null;
    }

    $query = "INSERT INTO users `login`, `password`, `role`, `surname`, `name`, `lastname`, `email` VALUES (?,?,?,?,?,?,?) WHERE `login` = ?;";
    $result = $db->SendQuery($query, [$login, $password, $role, $surname, $name, $lastname, $email, $newlogin]);

    // Проверка на доступность сервиса.
    if (!$result)
    {
        http_response_code(503);
        return null;
    }
    http_response_code(201);
    return null;
}
else
{
    http_response_code(405);
    return null;
}

?>