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

$sql ="SELECT payroll, 
round(SUM(basic),2) as basic, 
round(SUM(casual_labour),2) as casual_labour,
round(SUM(stewards_allowance),2) as stewards_allowance, 
round(SUM(displacement_allowance),2) as displacement_allowance, 
round(SUM(audit_allowance),2) as audit_allowance,
round(SUM(word_processing),2) as word_processing, 
round(SUM(sundry_allowance),2) as sundry_allowance, 
round(SUM(bonus),2) as bonus, 
round(SUM(car_allowance ),2) as car_allowance , 
round(SUM(staff_association),2) as staff_association,  
round(SUM(duty_allowance),2) as duty_allowance, 
round(SUM(overtime),2) as overtime, 
round(sum(transport),2) as transport, 
round(SUM(lunch),2) as lunch, 
round(SUM(gross_salary),2) as gross_salary, 
round(SUM(nassit_5),2) as employee_nassit,
round(SUM(medical_excess),2) as medical_excess,  
round(SUM(union_dues),2) as union_dues,  
round(SUM(rent),2) as rent, 
round(SUM(paye),2) as paye,
round(sum(total_deduction),2) as total_deduction,
round(SUM(net_salary),2) as net_salary,  
round(SUM(nassit10_deduct ),2) as employer_nassit,
round(SUM(witholding_tax),2) as witholding_tax, 
round(SUM(nassit10_payt),2) as nassit10_payt,
round(SUM(total_allowance),2) as total_allowance,
round(SUM(taxable_income),2) as taxable_income,
round(SUM(nassit5_contract),2) as nassit5_contract,
round(SUM(total_deduct_contract),2) as total_deduct_contract,
round(SUM(net_salary_contract),2) as net_salary_contract,
round(SUM(nassit10_payt_contr ),2) as nassit10_payt_contr,
round(SUM(nassit10_dedt_contr),2) as nassit10_dedt_contr, 
posting_date,
verified_by, 
approved_by, 
finalized_date,
documentRef
FROM vw_final_salaries WHERE payroll = '$id' GROUP BY payroll";

$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

$sql_ = "SELECT status from payroll where id = '$id'";
$result_ = mysqli_query($mysqli, $sql_);
$row_ = mysqli_fetch_assoc($result_);

$message = json_encode(
    array(
        "responseCode" => "000",
        "message" => "Successful",
        "data" => $row,
        "data1" => $row_,
    )

);

exit($message);
