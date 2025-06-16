<?php
// Удаление элемента в stocks.
session_start();

include_once("../config/database.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'DELETE')
{
    // Проверка на наличие пустых значений.
    if (Helper::isNull($_DELETE['ticker']))
    {
        http_response_code(400);
        return null;
    }

    $ticker = $_DELETE['ticker'];

    // Проверка прав пользователя.
    if ($_SESSION['priority'] <= 4)
    {
        http_response_code(403);
        return null;
    }

    $query = "DELETE FROM stocks WHERE `ticker` = ?;";
    $result = $db->SendQuery($query, [$ticker]);

    // Проверка на существование результата.
    if (!$result)
    {
        http_response_code(503);
        return null;
    }
    http_response_code(202);
    return null;
}
else
{
    http_response_code(405);
    return null;
}

?>