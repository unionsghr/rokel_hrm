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
$pdf->Cell(100, 6, 'EMPLOYEE EMERGENCY CONTACT LIST', 0, 0, 'C');
$date = date("Y-m-d");

$pdf->Cell(13, 7, 'Print date:', 0);
$pdf->Cell(15, 7, $date, 0);

$pdf->Ln(10);



//file headers
$display_heading = array(
  'employeedependents.id' => 'ID', 'first_name' => 'First name', 'last_name' => 'Last name', 'name' => 'Name', 'relationship' => 'Relationship', 'home_phone' => 'Home Phone', 'work_phone' => 'Work Phone', 'mobile_phone' => 'Mobile Phone'
);

//script for generating pdf
$result = $db->query("SELECT emergencycontacts.id, employees.first_name, employees.last_name, emergencycontacts.name, emergencycontacts.relationship,emergencycontacts.home_phone,emergencycontacts.work_phone, emergencycontacts.mobile_phone from emergencycontacts,employees where employees.id = emergencycontacts.employee;");
$header = $db->query("SHOW columns FROM Emergency contacts");

//display the headers for each cell
$pdf->SetWidths(array(10, 20, 20, 35, 25, 25, 25, 25));
// for ($i = 0; $i < 1; $i++) {
$pdf->Row(array('ID', 'First name', 'Last name', 'Name', 'Relationship', 'Home phone', 'Work phone', 'Mobile Phone'));
// }
// $pdf->Ln();
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10, 20, 20, 35, 25, 25, 25, 25));


//display the data in each cell
foreach ($result as $row) {
  // $pdf->Ln();
  // foreach ($row as $column)
  $pdf->Row(array($row['id'], $row['first_name'], $row['last_name'], $row['name'], $row['relationship'], $row['home_phone'], $row['work_phone'], $row['mobile_phone']));
}

$pdf->Output();

exit;
