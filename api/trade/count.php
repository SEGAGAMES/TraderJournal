<?php
ini_set('display_errors', 0);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/trade.php";

$database = new Database();
$db = $database->getConnection();

$trade = new Trade($db);
$trader = isset($_GET["trader"]) ? $_GET["trader"] : die();

$stmt = $trade->count($trader);
$num = $stmt->rowCount();

if ($num > 0) {
        
    http_response_code(200);
    echo json_encode($stmt->fetch(PDO::FETCH_NUM)[0]);
}
else 
    http_response_code(404);
?>
