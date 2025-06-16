<?php
// Создавние новой роли в roles.
session_start();

include_once("../config/database.php");
include_once("../config/helper.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // Проверка на наличие пустых значений.
    if (Helper::isNull([$_POST['role'], $_POST['priority']]))
    {
        http_response_code(400);
        echo null;
        die();
    }

    $role = $_POST['role'];
    $priority = $_POST['priority'];

    // Проверка прав пользователя.
    if ($_SESSION['priority'] <= 6)
    {
        http_response_code(403);
        echo null;
        die();
    }

    $query = "INSERT INTO roles `role`, `priority` VALUES (?,?);";
    $result = $db->SendQuery($query, [$role, $priority]);

    // Проверка на существование результата.
    if (!$result)
    {
        http_response_code(503);
        echo null;
        die();
    }
    http_response_code(201);
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