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
        echo null;
        die();
    }

    $ticker = $_DELETE['ticker'];

    // Проверка прав пользователя.
    if ($_SESSION['priority'] <= 4)
    {
        http_response_code(403);
        echo null;
        die();
    }

    $query = "DELETE FROM stocks WHERE `ticker` = ?;";
    $result = $db->SendQuery($query, [$ticker]);

    // Проверка на существование результата.
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