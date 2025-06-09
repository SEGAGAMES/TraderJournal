<?php
// �������� �������� � roles.

include_once("../config/database.php")
header("Content-Type: application/json");

$db = new Database();

// �������� ������ �������.
if ($_SERVER['REQUEST_METHOD'] === 'DELETE')
{
    // �������� �� ������� ������ ��������.
    if (Helper::isNull($_DELETE['role'], $_DELETE['userPriority'], $_DELETE['priority']))
    {
        http_response_code(400);
        return null;
    }

    $role = $_DELETE['role'];
    $userPriority = $_DELETE['userPriority'];
    $priority = $_DELETE['priority'];

    // �������� ���� ������������.
    if ($userPriority <= $priority)
    {
        http_response_code(403);
        return null;
    }

    $query = "DELETE FROM roles WHERE `role` = ?;";
    $result = $db->SendQuery($query, [$role]);

    // �������� �� ������������� ����������.
    if (!$result)
    {
        http_response_code(503);
        return null;
    }
    http_response_code(202);
    return null;
}
else
{
    http_response_code(405);
    return null;
}

?>