<?php
// Удаление элемента в roles.
session_start();

include_once("../config/database.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'DELETE')
{
    // Проверка на наличие пустых значений.
    if (Helper::isNull($_DELETE['role']))
    {
        http_response_code(400);
        echo null;
        die();
    }

    $role = $_DELETE['role'];

    // Проверка прав пользователя.
    if ($_SESSION['priority'] <= 6)
    {
        http_response_code(403);
        echo null;
        die();
    }

    $query = "DELETE FROM roles WHERE `role` = ?;";
    $result = $db->SendQuery($query, [$role]);

    // Проверка на существование результата.
    if (!$result)
    {
        http_response_code(503);
        echo null;
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