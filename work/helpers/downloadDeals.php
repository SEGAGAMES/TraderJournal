<?php
require_once 'config.php';
try {
$pdo = new PDO($attr, $user, $pass, $opts);
} catch (PDOException $e) {
throw new PDOException($e->getMessage(), (int) $e->getCode());
}
header('Content-Type: application/json');
$query = "SELECT * FROM trading";
$result = $pdo->query($query);
$deals = array();
$i = 0;
while ($row = $result->fetch(PDO::FETCH_BOTH)) {
$deals[$i] = array($row[0],$row[1],$row[2], $row[3], $row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10],$row[12]);
$i = $i + 1;
}
echo json_encode($deals);
?>
