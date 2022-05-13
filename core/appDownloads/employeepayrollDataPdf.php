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
$pdf->Cell(100, 6, 'EMPLOYEE PAYROLL', 0, 0, 'C');
$date = date("Y-m-d");
$pdf->Cell(13, 7, 'Print date:', 0);
$pdf->Cell(15, 7, $date, 0);

$pdf->Ln(10);





//script for generating pdf
$result = $db->query("SELECT payrollemployees.id,concat(employees.first_name,' ', employees.middle_name,' ', employees.last_name) Name,
 payfrequency.name pay_frequency,currencytypes.code currency,deductiongroup.name calculation_group
 FROM payrollemployees, employees,payfrequency,currencytypes,deductiongroup 
 WHERE employees.id = payrollemployees.employee and payfrequency.id = payrollemployees.pay_frequency and 
 currencytypes.id = payrollemployees.currency and deductiongroup.id = payrollemployees.deduction_group;");
$header = $db->query("SHOW columns FROM Employee Payroll");

//display the headers for each cell
$pdf->SetWidths(array(10, 60, 45, 25, 45));
// for ($i = 0; $i < 1; $i++) {
$pdf->Row(array('ID', 'Employee', 'Pay Frequency', 'Currency', 'Calculation Groups'));
// }
// $pdf->Ln();
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10, 60, 45, 25, 45));


//display the data in each cell
foreach ($result as $row) {
  // $pdf->Ln();
  // foreach ($row as $column)
  $pdf->Row(array($row['id'], $row['Name'], $row['pay_frequency'], $row['currency'], $row['calculation_group']));
}

$pdf->Output();

exit;
