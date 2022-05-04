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

$sql = "SELECT 
(select concat(first_name,' ', middle_name, ' ', last_name) from employees where id = employee) as employee,
dependant_name as dependant_name,
dob as dob,
relation_to_dependent as relationship,
from_date as from_date,
to_date as to_date,
admission_type as admission_type,
type_of_illness as type_of_illness,
medication_given as medication_given,
round(cost,2) as cost,
hospital as hospital,
physician as physician,
status as status,
approved_date as approved_date,
reference as reference,
(select concat(first_name,' ', middle_name, ' ', last_name) from employees where id = approved_by) as approved_by
from dependentmedical where id = $id";

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
