<?php
// ���������� ������ �������� �� roles.

include_once("../config/database.php")
header("Content-Type: application/json");

$db = new Database();

// �������� ������ �������.
if ($_SERVER['REQUEST_METHOD'] === 'GET')
{
    // �������� ��������� ������.
    if(!isset($_GET['role']))
    {
        http_response_code(400);
        return null;
    }

    $role = $_GET['role'];
    $query = "SELECT * FROM roles WHERE role = ?";

    $result = $db->SendQuery($query, [$role]);

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