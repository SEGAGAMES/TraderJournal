<?php
//ini_set('display_errors', 0);

include_once "database.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");
$username = isset($_GET["username"]) ? $_GET["username"] : die();
$username = urlencode($username);
$him = json_decode(file_get_contents('http://localhost/КР/api/user/readone.php?username=' . $username), true);
$role = $him[0]['role'];
// Загрузка приоритета.
$db = new Database();
$query = "SELECT `priority` FROM `role_priority` WHERE `role` = '$role'";
$stmt = $db->SendQuery($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$priority = $results[0]['priority'];
echo json_encode($priority);
?>