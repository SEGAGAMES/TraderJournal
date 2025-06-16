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
    if (Helper::isNull($_DELETE['login']))
    {
        http_response_code(400);
        echo null;
        die();
    }

    $login = $_DELETE['login'];

    // Проверка прав пользователя.
    if ($_SESSION['priority'] <= 8)
    {
        http_response_code(403);
        echo null;
        die();
    }

    $query = "DELETE FROM users WHERE `login` = ?;";
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