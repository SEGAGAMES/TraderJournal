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

$ticker = $_POST['ticker'] ?? null;
$futures = $_POST['futures'] ?? 1;
$exchange = $_POST['exchange'] ?? null;
if (Stock::Create($ticker, $futures, $exchange))
    http_response_code(201);
else
    http_response_code(503);
?>