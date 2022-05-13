<?php
include_once 'dbConfig.php';

function filterData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "EmployeePayroll_" . date('Y-m-d') . ".xls";

// Column names 
$fields = array(
  'ID',
  'EMPLOYEE',
  'PAY FREQUENCY',
  'CURRENCY',
  'CALCULATION GROUP'
);

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from database 
$query = $db->query("SELECT payrollemployees.id,concat(employees.first_name,' ', employees.middle_name,' ', employees.last_name) Name,
 payfrequency.name pay_frequency,currencytypes.code currency,deductiongroup.name calculation_group
 FROM payrollemployees, employees,payfrequency,currencytypes,deductiongroup 
 WHERE employees.id = payrollemployees.employee and payfrequency.id = payrollemployees.pay_frequency and 
 currencytypes.id = payrollemployees.currency and deductiongroup.id = payrollemployees.deduction_group;");
if ($query->num_rows > 0) {
  // Output each row of the data 
  while ($row = $query->fetch_assoc()) {
    // $status = ($row['status'] == 1)?'Active':'Inactive'; 
    $lineData = array(
      $row['id'],
      $row['Name'],
      $row['pay_frequency'],
      $row['currency'],
      $row['calculation_group']
    );
    array_walk($lineData, 'filterData');
    $excelData .= implode("\t", array_values($lineData)) . "\n";
  }
} else {
  $excelData .= 'No records found...' . "\n";
}

// Headers for download 
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$fileName\"");

// Render excel data 
echo $excelData;

exit;
