<?php
session_start();
ini_set('display_errors', 0);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../objects/stock.php";

if ($_SESSION['priority'] <= 4)
{
	http_response_code(403);
	die();
}

$ticker = $_GET['ticker'] ?? null;
if (Stock::Delete($ticker)->rowCount() > 0) 
    http_response_code(200);
else 
    http_response_code(404);
?>
