<?php
// Обновление одного элемента в roles.

session_start();

include_once("../config/database.php");
include_once("../config/helper.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'PUT')
{
    // Проверка на наличие пустых значений.
    if (Helper::isNoOneNull($_PUT['newRole'], $_PUT['role'], $_PUT['priority']))
    {
        http_response_code(400);
        echo null;
        die();
    }

    $newRole = $_PUT['newRole'];
    $role = $_PUT['role'];
    $priority = $_PUT['priority'];

    // Проверка прав пользователя.
    if ($_SESSION['priority'] <= 6)
    {
        http_response_code(403);
        echo null;
        die();
    }

    $query = "INSERT INTO roles `role`, `priority` VALUES (?,?) WHERE `role` = ?;";
    $result = $db->SendQuery($query, [$newRole, $priority, $role]);

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