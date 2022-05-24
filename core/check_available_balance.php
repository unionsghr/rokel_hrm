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
// echo $json;
// die();
// Converts it into a PHP object
$data = json_decode($json);


//get the employee id
$employee_id = $data->employee;

//select the balance of the employee with that id
$sql = " select balance from medenquiry WHERE emp_id = '$employee_id'";
$result = mysqli_query($mysqli, $sql);


$balance_data = mysqli_fetch_assoc($result);
$balance = $balance_data['balance'];


// echo json_encode($data);
$message = json_encode(
  array(
    "responseCode" => "000",
    "message" => "Balance quried",
    "data" => $balance

  )

);

exit($message);
