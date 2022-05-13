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

// $paygrade_id = $data->paygrade_id;

/*
$employee_id = "393";
$reason = "Test";
$start_date = "2021-01-08";
$end_date = "2021-01-28";
$salary_rate = "12";
*/
$sql = " select u.id,u.employee,e.first_name,e.last_name from employees e,users u where u.employee = e.id;";
$result = mysqli_query($mysqli, $sql);

$data = array();
while ($users = mysqli_fetch_assoc($result)) {
  $a = array($users['employee'], $users['first_name'], $users['last_name']);
  array_push($data, $a);
}


// echo json_encode($data);
$message = json_encode(
  array(
    "responseCode" => "000",
    "message" => "users quried",
    "data" => $data,
    // "data1"=> $row_['expense_gl']

  )

);

exit($message);
