<?php
include_once 'dbConfig.php';

function filterData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if (strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

// Excel file name for download 
$fileName = "Salaries_" . date('Y-m-d') . ".xls";

// Column names 
$fields = array(
  'ID',
  'COMPONENT/NOTCH',
  'INCREMENT/DECREMENT',
  '%CHANGE',
  'DATE'
);

// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n";

// Fetch records from database 
$query = $db->query("SELECT salaries.id,notches.name,salaries.state,salaries.percentage_change,salaries.date FROM `salaries`,`notches` where notches.id=salaries.component;");
if ($query->num_rows > 0) {
  // Output each row of the data 
  while ($row = $query->fetch_assoc()) {
    // $status = ($row['status'] == 1)?'Active':'Inactive'; 
    $lineData = array(
      $row['id'],
      $row['name'],
      $row['state'],
      $row['percentage_change'],
      $row['date']
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
