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
        return null;
    }
    
    // Проверка на присутствие результата.
    if ($result->rowCount < 1)
    {
        http_response_code(404);
        return null;
    }

    $users = [];
    while ($row = $result->fetch(PDO::FETCH_ASSOC))
        $users[] = $row;

    http_response_code(200);
    return json_encode($users);
}
else
{
    http_response_code(405);
    return null;
}

?>