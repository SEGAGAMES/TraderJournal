<?php
ini_set('display_errors', 0);
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/trade.php";

if ($_SESSION['priority'] <= 0)
{
	http_response_code(403);
	die();
}

$database = new Database();
$db = $database->getConnection();

$trade = new Trade($db);
$trade->ticker = $_POST['ticker'];
$trade->deal_type = $_POST['deal_type'];
$trade->cost = $_POST['cost'];
$trade->futures = $_POST['futures'];
$trade->count = $_POST['count'];
$trade->date = $_POST['date'];
$trade->time = $_POST['time'];

$upload_dir = '../../work/data/uploads/';
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];

if (!file_exists($upload_dir))
    mkdir($upload_dir, 0777, true);
    
$file_name = $_FILES['photo']['name'];
$file_tmp = $_FILES['photo']['tmp_name'];
$file_type = $_FILES['photo']['type'];
$file_size = $_FILES['photo']['size'];
$file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
// Генерируем уникальное имя файла
$new_file_name = uniqid('img_', true) . '.' . $file_ext;
$file_path = $upload_dir . $new_file_name;
move_uploaded_file($file_tmp, $file_path);
$trade->path = $file_path;
echo json_encode($_FILES['photo']);

checkInput($trade->id);
checkInput($trade->deal_type);
checkInput($trade->cost);
checkInput($trade->futures);
checkInput($trade->count);

$traders_list = $_POST['traders_list'];
$trade->traders = !empty($traders_list) ? explode(', ', $traders_list) : [];
if (!$trade->isNull())
    if ($trade->create())
        http_response_code(201);
    else
        http_response_code(503);
else 
    http_response_code(400);

function checkInput($inputStr)
{
    $specialChars = '/[!@#$%^&*()+\-=\[\]{};\':"\\\\|,.<>\/?]+/';
    if (preg_match($specialChars, $inputStr)) {
        http_response_code(400);
        die();
    }
}
?>
