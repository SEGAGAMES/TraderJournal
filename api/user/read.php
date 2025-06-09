<?php
ini_set('display_errors', 0);
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once "../objects/user.php";

$stmt = User::Read();
$num = $stmt->rowCount();

if ($num > 0)
{
    $users_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        extract($row);
        $user_item = array(
            "username" => $username,
            "password" => $password,
            "role" => $role,
        );
        array_push($users_arr, $user_item);
    }
    http_response_code(200);
    echo json_encode($users_arr);
}
else
    http_response_code(404);
?>
