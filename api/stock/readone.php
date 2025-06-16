<?php
// Считывание одного тикера из stocks.

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

    $ticker = $_GET['ticker'];
    $query = "SELECT * FROM stocks WHERE ticker = ?";

    $result = $db->SendQuery($query, [$ticker]);

    // Проверка на доступность сервиса.
    if (!$result)
    {
        http_response_code(503);
        echo null;
        die();
    }
    
    // Проверка на наличие результата.
    if ($result->rowCount() < 1)
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