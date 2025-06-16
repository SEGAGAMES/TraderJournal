<?php
// Создание нового тикера в stocks.

session_start();

include_once("../config/database.php");
include_once("../config/helper.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода.
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // Проверка введенных параметров.
    if (Helper::isNull($_POST['ticker'], $_POST['futures'], $_POST['exchange']))
    {
        http_response_code(400);
        return null;
    }

    $ticker = $_POST['ticker'];
    $futures = $_POST['futures'];
    $exchange = $_POST['exchange'];

    // Проверка прав доступа.
    if ($_SESSION['priority'] <= 4)
    {
        http_response_code(403);
        return null;
    }

    $query = "INSERT INTO stocks `ticker`, `futures`, `exchange` VALUES (?,?,?);";
    $result = $db->SendQuery($query, [$ticker, $futures, $exchange]);

    // Проверка доступности сервиса.
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