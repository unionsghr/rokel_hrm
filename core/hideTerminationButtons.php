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
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);

$employee_id = $data->id_;
// $currentProfile = $data->currentProfile_;

    $sql = " SELECT approval_status, posted_by, termination_status from employees WHERE id = $employee_id";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);

$message = json_encode(
    array(
        "responseCode" => "000",
        "message" => "Termination Status Successfully Retrieved",
        "data" => $row['termination_status']
        // "data1"=> $row['posted_by'],
        // "data2"=> $currentProfile

    )
);

exit($message);
