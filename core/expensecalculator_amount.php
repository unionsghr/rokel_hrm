<?php

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$mysqli = mysqli_connect("localhost", "root", "", "hrmdata");
if (mysqli_connect_errno($mysqli)) {
    // echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// // Takes raw data from the request
$json = file_get_contents('php://input');

$data = json_decode($json);

// // $currency = $data->currency;
// // $amount = $data->amount;

// echo $data->id; die();

$id = isset($data->id) ? $data->id : 0;
// $id = isset($data->id);
// $id = 13;
// $items = isset($data->items);

$sql = "SELECT items FROM `employeeexpenses` WHERE id = '$id' LIMIT 1";

$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);
// echo $row = json_encode($row['items']);die();

$items = json_decode($row['items']);

// echo json_encode($items); die();

$total_sum = 0;

foreach ($items as $item) {
    // print_r($item);
    $total_sum = $total_sum + (float) $item->local_equivalent;
}

// echo $total_sum; die();

$sql_ = "UPDATE `employeeexpenses` SET `amount` = '$total_sum' WHERE `employeeexpenses`.`id` = '$id' ";

$result_ = mysqli_query($mysqli, $sql_);

$message = json_encode(
    array(
        "responseCode" => "000",
        "message" => "Calculated amount",
        "data" => $total_sum,
    )

);

exit($message);
