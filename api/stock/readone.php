<?php
// ���������� ������ �������� �� roles.

include_once("../config/database.php")
header("Content-Type: application/json");

$db = new Database();

// �������� ������ �������.
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    // �������� ��������� ������.
    if(!isset($_GET['ticker']))
    {
        http_response_code(400);
        return null;
    }

    $ticker = $_GET['ticker'];
    $query = "SELECT * FROM stocks WHERE ticker = ?";

    $result = $db->SendQuery($query, [$ticker]);

    // �������� �� ������������� ����������.
    if (!$result)
    {
        http_response_code(503);
        return null;
    }
    
    // �������� ����� ������.
    if ($result->rowCount < 1)
    {
        http_response_code(404);
        return null;
    }

    $result = $result->fetch(PDO::FETCH_ASSOC);

    http_response_code(200);
    echo json_encode($result);
}
else
{
    http_response_code(405);
    return null;
}
?>