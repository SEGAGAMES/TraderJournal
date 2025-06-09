<?php
ini_set('display_errors', 0);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/stock.php";

$database = new Database();
$db = $database->getConnection();

$stock = new Stock($db);
$stock->ticker = isset($_GET["ticker"]) ? $_GET["ticker"] : die();

$stmt = $stock->search();
$num = $stmt->rowCount();

if ($num > 0)
{
    $stocks_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        $stock_item = array(
            "id" => $id,
            "ticker" => $ticker,
            "futures" => $futures,
            "exchange" => $exchange,
        );
        array_push($stocks_arr, $stock_item);
    }
    http_response_code(200);
    echo json_encode($stocks_arr);
}
else
        http_response_code(404);
?>