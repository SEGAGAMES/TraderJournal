<?php
ini_set('display_errors', 0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/trader.php";

$database = new Database();
$db = $database->getConnection();

$trader = new Trader($db);
$trader->last = isset($_GET["last"]) ? $_GET["last"] : die();

$stmt = $trader->search();
$num = $stmt->rowCount();

if ($num > 0) {
    $trades_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        $trade_item = array(
            "id" => $id,
            "last" => $last,
            "name" => $name,
            "sur" => $sur,
        );
        array_push($trades_arr, $trade_item);
    }
    http_response_code(200);
    echo json_encode($trades_arr);
}
else
    http_response_code(404);
?>
