<?php
ini_set('display_errors', 0);
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../objects/trader.php";

if ($_SESSION['priority'] <= 5)
{
	http_response_code(403);
	die();
}

$username = $_POST['username'] ?? null;
$last = $_POST['last'] ?? null;
$name = $_POST['name'] ?? null;
$sur = $_POST['sur'] ?? null;

checkInput($last);
checkInput($name);
checkInput($sur);
if (Trader::Update($username, $last, $name, $sur))
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