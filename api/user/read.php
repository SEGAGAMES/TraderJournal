<?php
// Считывание всех пользователей.

include_once("../config/database.php");
header("Content-Type: application/json");

$db = new Database();

// Проверка допустимого метода.
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    $query = "SELECT * FROM users";

    $result = $db->SendQuery($query);

    // Проверка на доступность сервиса.
    if (!$result)
    {
        http_response_code(503);
        echo null;
        die();
    }
    
    // Проверка на присутствие результата.
    if ($result->rowCount < 1)
    {
        http_response_code(404);
        echo null;
        die();
    }

    $users = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC))
        $users[] = $row;

    http_response_code(200);
    echo json_encode($users);
    die();
}
else
{
    http_response_code(405);
    echo null;
    die();
}

?>