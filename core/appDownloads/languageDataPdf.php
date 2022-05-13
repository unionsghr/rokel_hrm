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
$pdf->Cell(100, 6, 'EMPLOYEE LANGUAGE LIST', 0, 0, 'C');
$date = date("Y-m-d");
$pdf->Cell(13, 7, 'Print date:', 0);
$pdf->Cell(15, 7, $date, 0);

$pdf->Ln(10);



//file headers
$display_heading = array(
  'employeelanguages.id' => 'ID', 'first_name' => 'First name', 'last_name' => 'Last name', 'name' => 'Language', 'reading' => 'Reading', 'speaking' => 'Speaking', 'writing' => 'Writing', 'understanding' => 'Understanding'
);

//script for generating pdf
$result = $db->query("SELECT employeelanguages.id,EMPLOYEES.first_name, EMPLOYEES.last_name, languages.name, employeelanguages.reading, employeelanguages.speaking,employeelanguages.writing,employeelanguages.understanding FROM employeelanguages,languages,employees WHERE language_id = languages.id AND employee = employees.ID ORDER BY id ASC;");
$header = $db->query("SHOW columns FROM Language");

//display the headers for each cell
$pdf->SetWidths(array(10, 25, 25, 20, 30, 25, 25,25));
// for ($i = 0; $i < 1; $i++) {
$pdf->Row(array('ID', 'First name', 'Last name', 'Language', 'Reading', 'Speaking', 'Writing', 'Understanding'));
// }
// $pdf->Ln();
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10, 25, 25, 20, 30, 25, 25,25));


//display the data in each cell
foreach ($result as $row) {
  // $pdf->Ln();
  // foreach ($row as $column)
  $pdf->Row(array($row['id'], $row['first_name'], $row['last_name'], $row['name'], $row['reading'], $row['speaking'], $row['writing'], $row['understanding']));
}

$pdf->Output();

exit;
