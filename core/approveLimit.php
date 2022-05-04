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
$currentUser = $data->currentUser;

$sql = "UPDATE medicallimit set status = 'Approved', approved_date = CURRENT_DATE, approved_by = $currentUser where id = '$id'";

$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

// echo json_encode($row); die();
$message = json_encode(
    array(
        "responseCode" => "000",
        "message" => "Successfully Approved",
        "data" => $row,
    )

);

exit($message);
