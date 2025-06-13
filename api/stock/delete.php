<?php
// Удаление элемента в stocks.

include_once("../config/database.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'DELETE')
{
    // Проверка на наличие пустых значений.
    if (Helper::isNull($_DELETE['ticker'], $_DELETE['userPriority'], $_DELETE['priority']))
    {
        http_response_code(400);
        return null;
    }

    $ticker = $_DELETE['ticker'];
    $userPriority = $_DELETE['userPriority'];
    $priority = $_DELETE['priority'];

    // Проверка прав пользователя.
    if ($userPriority <= $priority)
    {
        http_response_code(403);
        return null;
    }

    $query = "DELETE FROM stocks WHERE `tocker` = ?;";
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