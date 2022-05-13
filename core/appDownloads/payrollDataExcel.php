<?php
include_once 'dbConfig.php';

function filterData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "Payroll_" . date('Y-m-d') . ".xls";

// Column names 
$fields = array(
  'ID',
  'PAY FREQUENCY',
  'DEPARTMENT',
  'PAYMENT TYPE',
  'PAY PERIOD',
  'STATUS',
  'POSTING REFERENCE'
);

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from database 
$query = $db->query("SELECT payroll.id,payfrequency.name,companystructures.title,payroll.type,payroll.pay_month,payroll.status,payroll.documentRef 
FROM payroll,payfrequency,companystructures
 WHERE payfrequency.id = payroll.pay_period and companystructures.id = payroll.department ORDER BY payroll.id ASC;");
if ($query->num_rows > 0) {
  // Output each row of the data 
  while ($row = $query->fetch_assoc()) {
    // $status = ($row['status'] == 1)?'Active':'Inactive'; 
    $lineData = array(
      $row['id'],
      $row['name'],
      $row['title'],
      $row['type'],
      $row['pay_month'],
      $row['status'],
      $row['documentRef'],
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
