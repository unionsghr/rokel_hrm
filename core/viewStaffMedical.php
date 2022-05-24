<?php
// use Utils\LogManager;

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
employee as emp_id,
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
from staffmedical where id = $id";

$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

$employee_id = $row['emp_id'];

//select the balance of the employee
// $sql1 = " select balance from medenquiry WHERE emp_id = '$employee_id'";
// $result1 = mysqli_query($mysqli, $sql1);

// $balance_data = mysqli_fetch_assoc($result1);
// $balance = $balance_data['balance'];

$message = json_encode(
    array(
        "responseCode" => "000",
        "message" => "Successful",
        "data" => $row,
        // "data1" => $balance
    )

);

exit($message);
