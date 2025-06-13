<?php
// Обновление одного элемента в stocks.

include_once("../config/database.php");
include_once("../config/helper.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'PUT')
{
    // Проверка на наличие пустых значений.
    if (Helper::isNoOneNull($_PUT['ticker'], $_PUT['newticker'], $_PUT['userPriority'], $_PUT['futures'], $_PUT['exchange'], $_PUT['priority']))
    {
        http_response_code(400);
        return null;
    }

    $ticker = $_PUT['ticker'];
    $newticker = $_PUT['newticker'];
    $futures = $_PUT['futures'];
    $exchange = $_PUT['exchange'];
    $priority = $_PUT['priority'];
    $userPriority = $_PUT['userPriority'];

    // Проверка прав пользователя.
    if ($userPriority <= $priority)
    {
        http_response_code(403);
        return null;
    }

    $query = "INSERT INTO stocks `ticker`, `exchange`, `futures` VALUES (?,?,?) WHERE `ticker` = ?;";
    $result = $db->SendQuery($query, [$newticker, $$exchange, $futures, $ticker]);

    // Проверка на доступность сервиса.
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