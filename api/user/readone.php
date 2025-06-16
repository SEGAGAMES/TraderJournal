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
        echo null;
        die();
    }

    $login = $_GET['login'];
    $query = "SELECT * FROM users WHERE login = ?";

    $result = $db->SendQuery($query, [$login]);

    // Проверка на доступность сервиса.
    if (!$result)
    {
        http_response_code(503);
        echo null;
        die();
    }
    
    // Проверка на наличие результата.
    if ($result->rowCount < 1)
    {
        http_response_code(404);
        echo null;
        die();
    }

    $result = $result->fetch(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode($result);
    die();
}
else
{
    http_response_code(405);
    echo null;
    die();
}
?>