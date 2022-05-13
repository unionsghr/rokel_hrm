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
$result = $db->query("SELECT payroll.id,payfrequency.name,companystructures.title,payroll.type,payroll.pay_month,payroll.status,payroll.documentRef 
FROM payroll,payfrequency,companystructures
 WHERE payfrequency.id = payroll.pay_period and companystructures.id = payroll.department ORDER BY payroll.id ASC;");
$header = $db->query("SHOW columns FROM Payroll");

//display the headers for each cell
$pdf->SetWidths(array(10, 25, 35, 25, 30,30,30));
// for ($i = 0; $i < 1; $i++) {
$pdf->Row(array('ID', 'Pay Frequency', 'Department', 'Payment Type','Pay Period','Status','Posting Reference'));
// }
// $pdf->Ln();
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10, 25, 35, 25,30, 30, 30));


//display the data in each cell
foreach ($result as $row) {
  // $pdf->Ln();
  // foreach ($row as $column)
  $pdf->Row(array($row['id'], $row['name'], $row['title'], $row['type'], $row['pay_month'], $row['status'], $row['documentRef']));
}

$pdf->Output();

exit;
