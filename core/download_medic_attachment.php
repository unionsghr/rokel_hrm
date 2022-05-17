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

$staff_id = $data->staffMedicalId;
// print($staff_id);
// die();

//get the attachment of that staff medical record
$sql = " select attachment1 from staffmedical WHERE id = '$staff_id'";
$result = mysqli_query($mysqli, $sql);

$notch = mysqli_fetch_array($result);

$data = $notch['attachment1'];


// while ($notch = mysqli_fetch_array($result)) {
//   $a = $notch['attachment1'];
//   array_push($data, $a);
// }

print_r($data);
die();


// echo json_encode($data);
$message = json_encode(
  array(
    "responseCode" => "000",
    "message" => "Notches queried",
    "data" => $data,
    // "data1"=> $row_['expense_gl']

  )

);

exit($message);
