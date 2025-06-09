<?php
//ini_set('display_errors', 0);
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/user.php";

$username = $_POST['username'] ?? null;
$password = isset($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : die("Введите пароль");
$role = $_POST['role'] ?? "user";

// Проверка на недопустимые символы.
checkInput($username);
checkInput($role);

// Проверка легетимности операции.
$db = new Database();
$query = "SELECT `priority` FROM `role_priority` WHERE `role` = '$role'";
$stmt = $db->SendQuery($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
$priority = $results[0]['priority'];
if (!isset($_SESSION['priority']))
    $_SESSION['priority'] = 1;
if ($_SESSION['priority'] <= $priority)
{
	http_response_code(403);
	die();
}

if (User::Create($username, $password, $role))
    http_response_code(201);
else
    http_response_code(409);
?>

<?php 
function checkInput($inputStr)
{
    $specialChars = '/[!@#$%^&*()+\-=\[\]{};\':"\\\\|,.<>\/?]+/';
    if (preg_match($specialChars, $inputStr)) {
        http_response_code(400);
        die();
    }
}
?>
