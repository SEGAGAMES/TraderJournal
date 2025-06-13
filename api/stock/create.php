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
    if (Helper::isNull($_POST['userPriority'], $_POST['priority'], $_POST['ticker'], $_POST['futures'], $_POST['exchange']))
    {
        http_response_code(400);
        return null;
    }

    $userPriority = $_POST['userPriority'];
    $priority = $_POST['priority'];
    $ticker = $_POST['ticker'];
    $futures = $_POST['futures'];
    $exchange = $_POST['exchange'];

    // �������� ���� ������������.
    if ($userPriority <= $priority)
    {
        http_response_code(403);
        return null;
    }

    $query = "INSERT INTO stocks `ticker`, `futures`, `exchange` VALUES (?,?,?);";
    $result = $db->SendQuery($query, [$ticker, $futures, $exchange]);

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