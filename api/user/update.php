<?php
session_start();
ini_set('display_errors', 0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../objects/user.php";

$username = isset($_POST["username"]) ? $_POST["username"] : null;

checkInput($username);

if ($_SESSION['priority'] <= json_decode(file_get_contents("http://localhost/КР/api/checkPriority.php?username=".$username), true))
{
	http_response_code(403);
	die();
}
$password = isset($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : null;
$role = isset($_POST["role"]) ? $_POST["role"] : null;

if (User::Update($username, $password, $role)->rowCount()>0)
	http_response_code(200);
else
	http_response_code(404);

function checkInput($inputStr)
{
    $specialChars = '/[!@#$%^&*()+\-=\[\]{};\':"\\\\|,.<>\/?]+/';
    if (preg_match($specialChars, $inputStr)) {
        http_response_code(400);
        die();
    }
}
?>
