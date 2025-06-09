<?php
// ��������� ����� ���� � roles.

include_once("../config/database.php")
include_once("../config/helper.php")
header("Content-Type: application/json");

$db = new Database();

// �������� ������ �������.
if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    // �������� �� ������� ������ ��������.
    if (Helper::isNull($_POST['userPriority'], $_POST['role'], $_POST['priority']))
    {
        http_response_code(400);
        return null;
    }

    $userPriority = $_POST['userPriority'];
    $role = $_POST['role'];
    $priority = $_POST['priority'];

    // �������� ���� ������������.
    if ($userPriority <= $priority)
    {
        http_response_code(403);
        return null;
    }

    $query = "INSERT INTO roles `role`, `priority` VALUES (?,?);";
    $result = $db->SendQuery($query, [$role, $priority]);

    // �������� �� ������������� ����������.
    if (!$result)
    {
        http_response_code(503);
        return null;
    }
    http_response_code(201);
    return null;
}
else
{
    http_response_code(405);
    return null;
}

?>