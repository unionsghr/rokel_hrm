<?php
include_once 'dbConfig.php';

function filterData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "EmergencyContact_" . date('Y-m-d') . ".xls";

// Column names 
$fields = array(
  'ID',
  'FIRST NAME',
  'LAST NAME',
  'NAME',
  'RELATIONSHIP',
  'HOME PHONE',
  'WORK PHONE',
  'MOBILE PHONE'
);

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from database 
$query = $db->query("SELECT emergencycontacts.id, employees.first_name, employees.last_name, emergencycontacts.name, emergencycontacts.relationship,emergencycontacts.home_phone,emergencycontacts.work_phone, emergencycontacts.mobile_phone from emergencycontacts,employees where employees.id = emergencycontacts.employee;");
if ($query->num_rows > 0) {
  // Output each row of the data 
  while ($row = $query->fetch_assoc()) {
    // $status = ($row['status'] == 1)?'Active':'Inactive'; 
    $lineData = array(
      $row['id'],
      $row['first_name'],
      $row['last_name'],
      $row['name'],
      $row['relationship'],
      $row['home_phone'],
      $row['work_phone'],
      $row['mobile_phone']
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
