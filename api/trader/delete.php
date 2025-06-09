<?php
ini_set('display_errors', 0);
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/trader.php";

$database = new Database();
$db = $database->getConnection();

if ($_SESSION['priority'] <= 5)
{
	http_response_code(403);
	die();
}


$trader = new Trader($db);
$trader->id = $_GET['id'] ?? 1;

if ($trader->delete())
    http_response_code(200);
else
    http_response_code(503);
?>