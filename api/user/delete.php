<?php
session_start();

//ini_set('display_errors', 0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../objects/user.php";

$username = $_GET['username'] ?? null;
if ($_SESSION['priority'] <= json_decode(file_get_contents("http://localhost/КР/api/config/checkPriority.php?username=".$username), true))
{
	echo json_encode(json_decode(file_get_contents("http://localhost/КР/api/config/checkPriority.php?username=".$username), true));
	http_response_code(403);
	die();
}

if ($user->delete()) 
	http_response_code(200);
else 
	http_response_code(503);
?>
