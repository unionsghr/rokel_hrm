<?php
include_once 'dbConfig.php';

//import free pdf a php pdf librabry
require('fpdf/fpdf.php');

//create a new object
$pdf = new FPDF();

//add page and styling
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 7);

// Move the file title to the right
$pdf->Cell(10);

//file title
$pdf->Cell(170, 10, 'Employee Certificate List', 1, 0, 'C');

//file headers
$display_heading = array(
  'employeecertifications.id' => 'ID', 'first_name' => 'First name', 'last_name' => 'Last name', 'name' => 'Certificate', 'institute' => 'Institute', 'date_start' => 'Granted on', 'date_end' => 'Valid thru'

);

//script for generating pdf
$result = $db->query("SELECT employeecertifications.id,EMPLOYEES.first_name, EMPLOYEES.last_name, certifications.name, employeecertifications.institute, employeecertifications.date_start,employeecertifications.date_end FROM employeecertifications,certifications,employees WHERE certification_id = certifications.id AND employee = employees.ID;");
$header = $db->query("SHOW columns FROM Certificate");


//generate space between the page title and the data displayed
$pdf->Ln();
$pdf->Ln();


$pdf->AliasNbPages();

//display the headers for each cell
foreach ($display_heading as $heading) {
  $pdf->Cell(28, 7, $heading, 1);
}

//display the data in each cell
foreach ($result as $row) {
  $pdf->Ln();
  foreach ($row as $column)
    $pdf->Cell(28, 7, $column, 1);
}

//output the data
$pdf->Output();

exit;
