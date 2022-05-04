<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$mysqli =  mysqli_connect("localhost", "root", "", "hrmdata");
    if (mysqli_connect_errno($mysqli)) {
        // echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
 
// Takes raw data from the request
$json = file_get_contents('php://input');

$data = json_decode($json);

$id = $data->employee_id;
// $id = '7';
// echo $id;die();


$sql = "Insert into employees (first_name, last_name, birthday, country, gender, place_of_birth, branch, mobile_phone, private_email, recruitment_date) SELECT first_name, last_name, sysdate(), country, gender, 'null', '000', mobile_phone, email, sysdate() FROM candidates where candidates.id = '$id'";

$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

$sql_ = "delete * FROM candidates where id = '$id'";

$result_ = mysqli_query($mysqli, $sql_);
$row = mysqli_fetch_assoc($result_);


$message = json_encode(
    array(
        "responseCode" => "000",
        "message" => "New Recruit Added Successfully",
        "data"=> "Cool"
           
    )
    
);

exit($message);

header("Location:http://localhost/rokel_hrm/app/?g=admin&n=candidates&m=admin_Recruitment");

