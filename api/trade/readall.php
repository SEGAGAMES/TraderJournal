<?php
ini_set('display_errors', 0);

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../config/database.php";
include_once "../objects/trade.php";

$database = new Database();
$db = $database->getConnection();

$trade = new Trade($db);
$stmt = $trade->readall();
$num = $stmt->rowCount();

if ($num > 0) {
    $trades_arr = array();

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        $trade_item = array(
            "id" => $id,
            "ticker" => $ticker,
            "deal_type" => $deal_type,
            "cost" => $cost,
            "futures" => $futures,
            "count" => $count,
            "turnover" => $turnover,
            "commission" => $commission,
            "date" => $date,
            "time" => $time,
            "traders" => explode(', ', $traders_list)
        );
        array_push($trades_arr, $trade_item);
    }
    http_response_code(200);
    echo json_encode($trades_arr);
}
else
    http_response_code(404);
?>
