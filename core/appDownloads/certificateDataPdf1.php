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
$pdf->Cell(100, 6, 'EMPLOYEE CERTIFICATE LIST', 0, 0, 'C');
$date = date("Y-m-d");
// $pdf->Cell(100, 6, 'Employee Certificate List', 1, 0, 'C');
$pdf->Cell(13, 7, 'Print date:', 0);
$pdf->Cell(15, 7, $date, 0);
// $pdf->Cell(30, $date, 1, 0, 'C');
// Line break
$pdf->Ln(10);



//file headers
$display_heading = array(
  'employeecertifications.id' => 'ID', 'first_name' => 'First name', 'last_name' => 'Last name', 'name' => 'Certificate', 'institute' => 'Institute', 'date_start' => 'Granted on', 'date_end' => 'Valid thru'
);

//script for generating pdf
$result = $db->query("SELECT employeecertifications.id,EMPLOYEES.first_name, EMPLOYEES.last_name, certifications.name, employeecertifications.institute, employeecertifications.date_start,employeecertifications.date_end FROM employeecertifications,certifications,employees WHERE certification_id = certifications.id AND employee = employees.ID ORDER BY id ASC;");
$header = $db->query("SHOW columns FROM Certificate");

//display the headers for each cell
$pdf->SetWidths(array(10, 25, 25, 45, 40, 20, 20));
// for ($i = 0; $i < 1; $i++) {
$pdf->Row(array('ID', 'First name', 'Last name', 'Certificate', 'Institute', 'Granted On', 'Valid Thru'));
// }
// $pdf->Ln();
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10, 25, 25, 45, 40, 20, 20));


//display the data in each cell
foreach ($result as $row) {
  // $pdf->Ln();
  // foreach ($row as $column)
  $pdf->Row(array($row['id'], $row['first_name'], $row['last_name'], $row['name'], $row['institute'], $row['date_start'], $row['date_end'],));
}

$pdf->Output();

exit;
