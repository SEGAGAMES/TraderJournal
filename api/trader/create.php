<?php
ini_set('display_errors', 0);
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../objects/trader.php";


$last = $_POST['last'] ?? null;
$name = $_POST['name'] ?? null;
$sur = $_POST['sur'] ?? null;
$username = $_POST['username'] ?? null;

checkInput($last);
checkInput($name);
checkInput($sur);
checkInput($username);

if (Trader::Create($username, $last, $name, $sur)) 
    http_response_code(201);
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