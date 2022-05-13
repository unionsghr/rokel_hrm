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
$pdf->Cell(100, 6, 'PAYROLL COLUMNS', 0, 0, 'C');
$date = date("Y-m-d");
$pdf->Cell(13, 7, 'Print date:', 0);
$pdf->Cell(15, 7, $date, 0);

$pdf->Ln(10);





//script for generating pdf
$result = $db->query("SELECT payrollcolumns.id,payrollcolumns.name,payrollcolumns.salarycomponent_gl,salarycomponenttype.name component_type,deductiongroup.name cal_grp 
from payrollcolumns,deductiongroup,salarycomponenttype 
where deductiongroup.id = payrollcolumns.deduction_group and salarycomponenttype.code = payrollcolumns.payment_deduction;");
$header = $db->query("SHOW columns FROM Payroll Columns");

//display the headers for each cell
$pdf->SetWidths(array(10, 60,40,40,40));
// for ($i = 0; $i < 1; $i++) {
$pdf->Row(array('ID', 'Name', 'Component GL','Component Type', 'Calculation Group'));
// }
// $pdf->Ln();
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10, 60,40,40,40));


//display the data in each cell
foreach ($result as $row) {
  // $pdf->Ln();
  // foreach ($row as $column)
  $pdf->Row(array($row['id'], $row['name'], $row['salarycomponent_gl'], $row['component_type'], $row['cal_grp']));
}

$pdf->Output();

exit;
