<?php
// Обновление одного элемента в stocks.
session_start();

include_once("../config/database.php");
include_once("../config/helper.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'PUT')
{
    // Проверка на наличие пустых значений.
    if (Helper::isNoOneNull($_PUT['ticker'], $_PUT['newticker'], $_PUT['futures'], $_PUT['exchange']))
    {
        http_response_code(400);
        echo null;
        die();
    }

    $ticker = $_PUT['ticker'];
    $newticker = $_PUT['newticker'];
    $futures = $_PUT['futures'];
    $exchange = $_PUT['exchange'];

    // Проверка прав пользователя.
    if ($_SESSION['priority'] <= 4)
    {
        http_response_code(403);
        echo null;
        die();
    }

    $query = "INSERT INTO stocks `ticker`, `exchange`, `futures` VALUES (?,?,?) WHERE `ticker` = ?;";
    $result = $db->SendQuery($query, [$newticker, $$exchange, $futures, $ticker]);

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