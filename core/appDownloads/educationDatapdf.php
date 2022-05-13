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
$pdf->Cell(100, 6, 'SKILLS LIST', 0, 0, 'C');
$date = date("Y-m-d");
// $pdf->Cell(100, 6, 'Employee Certificate List', 1, 0, 'C');
$pdf->Cell(13, 7, 'Print date:', 0);
$pdf->Cell(15, 7, $date, 0);
// $pdf->Cell(30, $date, 1, 0, 'C');
// Line break
$pdf->Ln(10);



//file headers
$display_heading = array(
  'employeeeducations.id' => 'ID', 'first_name' => 'First name', 'last_name' => 'Last name', 'name' => 'Qualification', 'institute' => 'Institute', 'date_start' => 'Start date', 'date_end' => 'Completed date'

);

//script for generating pdf
$result = $db->query("SELECT employeeeducations.id,first_name,last_name,name,institute,date_start,date_end from employeeeducations,employees,educations where employees.id = employeeeducations.employee and educations.id = education_id;");
$header = $db->query("SHOW columns FROM Education");

//display the headers for each cell
$pdf->SetWidths(array(10, 30, 30, 30, 40,25,25));
// for ($i = 0; $i < 1; $i++) {
$pdf->Row(array('ID', 'First Name', 'Last Name', 'Qualification', 'Institute','Start Date','Completed Date'));
// }
// $pdf->Ln();
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10, 30, 30, 30, 40,25,25));


//display the data in each cell
foreach ($result as $row) {
  // $pdf->Ln();
  // foreach ($row as $column)
  $pdf->Row(array($row['id'], $row['first_name'], $row['last_name'], $row['name'], $row['institute'], $row['date_start'], $row['date_end']));
}

$pdf->Output();

exit;
