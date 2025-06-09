<?php
// ���������� ������ �������� � roles.

include_once("../config/database.php")
include_once("../config/helper.php")
header("Content-Type: application/json");

$db = new Database();

// �������� ������ �������.
if ($_SERVER['REQUEST_METHOD'] === 'PUT')
{
    // �������� �� ������� ������ ��������.
    if (Helper::isNull($_PUT['newRole'], $_PUT['userPriority'], $_PUT['role'], $_PUT['priority']))
    {
        http_response_code(400);
        return null;
    }

    $newRole = $_PUT['newRole'];
    $role = $_PUT['role'];
    $priority = $_PUT['priority'];
    $userPriority = $_PUT['userPriority'];

    // �������� ���� ������������.
    if ($userPriority <= $priority)
    {
        http_response_code(403);
        return null;
    }

    $query = "INSERT INTO roles `role`, `priority` VALUES (?,?) WHERE `role` = ?;";
    $result = $db->SendQuery($query, [$newRole, $priority, $role]);

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