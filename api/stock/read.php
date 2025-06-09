<?php
// Считывание всех элементов из roles.

include_once("../config/database.php")
header("Content-Type: application/json");

$db = new Database();

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $query = "SELECT * FROM stocks";

    $result = $db->SendQuery($query);

    // Проверка на существование результата.
    if (!$result)
    {
        http_response_code(503);
        return null;
    }
    
    // Проверка длины ответа.
    if ($result->rowCount < 1)
    {
        http_response_code(404);
        return null;
    }

    $tickers = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC)
        $tickers[] = $row;

    http_response_code(200);
    echo json_encode($tickers);
}
else
{
    http_response_code(405);
    return null;
}

?>