<?php
// Считывание одного тикера из users.

include_once("../config/database.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода.
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    // Проверка введенных параметров.
    if(!isset($_GET['ticker']))
    {
        http_response_code(400);
        return null;
    }

    $login = $_GET['login'];
    $query = "SELECT * FROM users WHERE login = ?";

    $result = $db->SendQuery($query, [$login]);

    // Проверка на доступность сервиса.
    if (!$result)
    {
        http_response_code(503);
        return null;
    }
    
    // Проверка на наличие результата.
    if ($result->rowCount < 1)
    {
        http_response_code(404);
        return null;
    }

    $result = $result->fetch(PDO::FETCH_ASSOC);

    http_response_code(200);
    return json_encode($result);
}
else
{
    http_response_code(405);
    return null;
}
?>