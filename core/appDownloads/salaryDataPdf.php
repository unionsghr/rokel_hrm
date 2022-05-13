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
$pdf->Cell(100, 6, 'SALARIES', 0, 0, 'C');
$date = date("Y-m-d");
// $pdf->Cell(100, 6, 'Employee Certificate List', 1, 0, 'C');
$pdf->Cell(13, 7, 'Print date:', 0);
$pdf->Cell(15, 7, $date, 0);
// $pdf->Cell(30, $date, 1, 0, 'C');
// Line break
$pdf->Ln(10);





//script for generating pdf
$result = $db->query("SELECT salaries.id,notches.name,salaries.state,salaries.percentage_change,salaries.date FROM `salaries`,`notches` where notches.id=salaries.component;");
$header = $db->query("SHOW columns FROM Notch");

//display the headers for each cell
$pdf->SetWidths(array(10, 45, 45, 45, 45));
// for ($i = 0; $i < 1; $i++) {
$pdf->Row(array('ID', 'Component/Notch', 'Increment/Decrement', '%Change', 'Date'));
// }
// $pdf->Ln();
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10, 45, 45, 45, 45));


//display the data in each cell
foreach ($result as $row) {
  // $pdf->Ln();
  // foreach ($row as $column)
  $pdf->Row(array($row['id'], $row['name'], $row['state'], $row['percentage_change'], $row['date']));
}

$pdf->Output();

exit;
