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

$id = isset($data->id) ? $data->id : 0;

$sql = "SELECT * from vw_viewMedicalLimit where id = $id";

$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

// $sql_ = "SELECT status from payroll where id = '$id'";
// $result_ = mysqli_query($mysqli, $sql_);
// $row_ = mysqli_fetch_assoc($result_);

$message = json_encode(
    array(
        "responseCode" => "000",
        "message" => "Successful",
        "data" => $row
        // "data1" => $row_,
    )

);

exit($message);
