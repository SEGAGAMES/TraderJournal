<?php
ini_set('display_errors', 0);
session_start();

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

$trade = new Trade($db);
$trade->path = $file_path;
$trade->id = $_POST['id'] ?? 1;
$trade->ticker = $_POST['ticker'] ?? null;
$trade->deal_type = $_POST['deal_type'] ?? null;
$trade->cost = $_POST['cost'] ?? null;
$trade->futures = $_POST['futures'] ?? 1;
$trade->count = $_POST['count'] ?? null;
$trade->date = $_POST['date'] ?? null;
$trade->time = $_POST['time'] ?? null;

checkInput($trade->id);
checkInput($trade->ticker);
checkInput($trade->deal_type);
checkInput($trade->cost);
checkInput($trade->futures);
checkInput($trade->count);

if (!$trade->isNoOneNull())
    if ($trade->update())
        http_response_code(202);
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
