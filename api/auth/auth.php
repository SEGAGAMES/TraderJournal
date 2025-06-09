<?php
ini_set('session.gc_maxlifetime', 3600);
ini_set('session.cookie_lifetime', 3600);
session_start();
ini_set('display_errors', 0);

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json");

include_once "../objects/user.php";
include_once "../config/database.php";

// Проверка на недопустимые символы.
checkInput($_POST['username']);


$username = isset($_POST["username"]) ? $_POST["username"] : die();
$password = isset($_POST["password"]) ? $_POST["password"] : die();
$urlusername = urlencode($username);
$him = json_decode(file_get_contents('http://localhost/КР/api/user/readone.php?username=' . $urlusername), true);
$db = new Database();
// Загрузка приоритета.
$query = "SELECT `priority` FROM `role_priority` WHERE `role` = '" . $him[0]['role'] . "'";
$stmt = $db->SendQuery($query);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (password_verify($password, $him[0]['password']))
{
    http_response_code(200);
    $_SESSION['username'] = $username;
    $_SESSION['priority'] = $results[0]['priority'];
}
else 
    http_response_code(409);
?>
<?php
function checkInput($inputStr)
{
    $specialChars = '/[!@#$%^&*()_+\-=\[\]{};\':"\\\\|,.<>\/?]+/';
    if (preg_match($specialChars, $inputStr)) {
        http_response_code(400);
        die();
    }
}
?>