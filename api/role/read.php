<?php
// Считывание всех элементов из roles.

include_once("../config/database.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка метода запроса.
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $query = "SELECT * FROM roles";

    $result = $db->SendQuery($query);

    // Проверка на существование результата.
    if (!$result)
    {
        http_response_code(503);
        echo null;
        die();
    }
    
    // Проверка длины ответа.
    if ($result->rowCount() < 1)
    {
        http_response_code(404);
        echo null;
        die();
    }

    $roles = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC))
        $roles[] = $row;

    http_response_code(200);
    echo json_encode($roles);
    die();
}
else
{
    http_response_code(405);
    echo null;
    die();
}

?>