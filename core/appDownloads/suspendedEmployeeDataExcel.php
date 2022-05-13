<?php
include_once 'dbConfig.php';

function filterData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "SuspendedEmployee_" . date('Y-m-d') . ".xls";

// Column names 
$fields = array(
  'ID',
  'FIRST NAME',
  'MIDDLE NAME',
  'LAST NAME',
  'MOBILE PHONE',
  'DEPARTMENT',
  'GENDER',
  'STATUS',
  'SUPERVISOR'
);

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from database 
$query = $db->query("SELECT vw_employeedata.id, vw_employeedata.first_name, vw_employeedata.middle_name,vw_employeedata.last_name,vw_employeedata.mobile_phone,companystructures.description,vw_employeedata.gender,vw_employeedata.status, concat(employees.first_name,' ',employees.last_name) supervisor from vw_employeedata,employees,companystructures where vw_employeedata.status = 'Suspended' and employees.id = vw_employeedata.supervisor and vw_employeedata.department = companystructures.id;");
if ($query->num_rows > 0) {
  // Output each row of the data 
  while ($row = $query->fetch_assoc()) {
    // $status = ($row['status'] == 1)?'Active':'Inactive'; 
    $lineData = array(
      $row['id'],
      $row['first_name'],
      $row['middle_name'],
      $row['last_name'],
      $row['mobile_phone'],
      $row['description'],
      $row['gender'],
      $row['status'],
      $row['supervisor']
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
