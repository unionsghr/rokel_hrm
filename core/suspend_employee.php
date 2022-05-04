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
 
$employee_id = $data->employee_id;
$reason = $data->reason;
$start_date = $data->start_date;
$end_date = $data->end_date;
$salary_rate = $data->salary_rate;
/*
$employee_id = "393";
$reason = "Test";
$start_date = "2021-01-08";
$end_date = "2021-01-28";
$salary_rate = "12";
*/
    $sql = " UPDATE employees SET suspension_reason = '$reason', suspension_start_date = '$start_date', suspension_end_date = '$end_date', suspension_salary_rate = '$salary_rate', status = 'Suspended', suspension_sysdate = CURRENT_DATE WHERE id = '$employee_id'";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);

    $sql_amt = " UPDATE employeesalary SET original_amount = amount WHERE employee = '$employee_id' AND component = '1'";
    $result_amt = mysqli_query($mysqli, $sql_amt);
    $row = mysqli_fetch_assoc($result_amt);

    $sql_ = " UPDATE employeesalary SET amount = (amount - (amount*$salary_rate/100)) WHERE employee = '$employee_id' AND component = '1'";
    $result_ = mysqli_query($mysqli, $sql_);
    $row = mysqli_fetch_assoc($result_);



$message = json_encode(
    array(
        "responseCode" => "000",
        "message" => "Calculated local cureency",
        "data" => $row['local_currency'],
        // "data1"=> $row_['expense_gl']

    )

);

exit($message);
