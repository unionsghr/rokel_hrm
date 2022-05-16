<?php
include_once 'dbConfig.php';

function filterData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "EmployeeCertifications_" . date('Y-m-d') . ".xls";

// Column names 
$fields = array(
  'ID',
  'FIRST NAME',
  'LAST NAME',
  'CERTIFICATE',
  'INSTITUTION',
  'GRANTED ON',
  'VALID THRU'
);

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from database 
$query = $db->query("SELECT employeecertifications.id,EMPLOYEES.first_name, EMPLOYEES.last_name, certifications.name, employeecertifications.institute, employeecertifications.date_start,employeecertifications.date_end FROM employeecertifications,certifications,employees WHERE certification_id = certifications.id AND employee = employees.ID;");
if ($query->num_rows > 0) {
  // Output each row of the data 
  while ($row = $query->fetch_assoc()) {
    // $status = ($row['status'] == 1)?'Active':'Inactive'; 
    $lineData = array(
      $row['id'],
      $row['first_name'],
      $row['last_name'],
      $row['name'],
      $row['institute'],
      $row['date_start'],
      $row['date_end']
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
