<?php
session_start();
ini_set('display_errors', 0);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/trade.php";

$database = new Database();
$db = $database->getConnection();

if ($_SESSION['priority'] <= 0)
{
	http_response_code(403);
	die();
}

$trade = new Trade($db);
$trade->id = isset($_GET["id"]) ? $_GET["id"] : die();
checkInput($trade->id);

if ($trade->delete()) 
    http_response_code(200);
else 
    http_response_code(503);

function checkInput($inputStr)
{
    $specialChars = '/[!@#$%^&*()+\-=\[\]{};\':"\\\\|,.<>\/?]+/';
    if (preg_match($specialChars, $inputStr)) {
        http_response_code(400);
        die();
    }
}
?>

