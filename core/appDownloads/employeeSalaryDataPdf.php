<?php
include_once 'dbConfig.php';

//import free pdf a php pdf librabry
require('fpdf/mc_table.php');





$pdf = new PDF_MC_Table();

$pdf->AddPage();

// Logo
$pdf->Image("../../../rokel_hrm/app/logo1.png", 100, 4, 28);
$pdf->SetFont('Arial', 'B', 7);

$pdf->Ln(5);

// Move the file title to the right
$pdf->Cell(49);

//file title
$pdf->Cell(100, 6, 'EMPLOYEE SALARY', 0, 0, 'C');
$date = date("Y-m-d");
$pdf->Cell(13, 7, 'Print date:', 0);
$pdf->Cell(15, 7, $date, 0);

$pdf->Ln(10);



//file headers
$display_heading = array(
  'employeesalary.id' => 'ID', 'first_name' => 'First name','middle_name' => 'Middle name', 'last_name' => 'Last name', 'name' => 'Salary Component'
);

//script for generating pdf
$result = $db->query("select employeesalary.id,employees.first_name,employees.middle_name,employees.last_name, salarycomponent.name from employeesalary,employees,salarycomponent where employees.id = employeesalary.id and salarycomponent.id = employeesalary.component;");
$header = $db->query("SHOW columns FROM Employee Salary");

//display the headers for each cell
$pdf->SetWidths(array(10, 45, 45, 45, 45));
// for ($i = 0; $i < 1; $i++) {
$pdf->Row(array('ID', 'First name', 'Middle name', 'Last name', 'Salary Component'));
// }
// $pdf->Ln();
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10, 45, 45, 45, 45));


//display the data in each cell
foreach ($result as $row) {
  // $pdf->Ln();
  // foreach ($row as $column)
  $pdf->Row(array($row['id'], $row['first_name'], $row['middle_name'], $row['last_name'], $row['name']));
}

$pdf->Output();

exit;
