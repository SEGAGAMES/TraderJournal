<?php
// Считывание одного элемента из roles.

include_once("../config/database.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    // Проверка введенных данных.
    if(!isset($_GET['role']))
    {
        http_response_code(400);
        echo null;
    }

    $role = $_GET['role'];
    $query = "SELECT * FROM roles WHERE role = ?";

    $result = $db->SendQuery($query, [$role]);

    // Проверка на существование результата.
    if (!$result)
    {
        http_response_code(503);
        echo null;
        die();
    }
    
    // Проверка длины ответа.
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