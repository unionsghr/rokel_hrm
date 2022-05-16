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
$pdf->Cell(100, 6, 'EMPLOYEE LIST', 0, 0, 'C');
$date = date("Y-m-d");
// $pdf->Cell(100, 6, 'Employee Certificate List', 1, 0, 'C');
$pdf->Cell(13, 7, 'Print date:', 0);
$pdf->Cell(15, 7, $date, 0);
// $pdf->Cell(30, $date, 1, 0, 'C');
// Line break
$pdf->Ln(10);



//file headers
//file headers
$display_heading = array(
	'id' => 'ID', 'employee_id' => 'Employee Id', 'first_name' => 'First name',
	'middle_name' => 'Middle name', 'last_name' => 'Last name', 'mobile_phone' => 'Mobile Phone', 'department' => 'Department',
	'status' => 'Status'
);

//script for generating pdf
$result = $db->query("SELECT id, employee_id, first_name, middle_name, last_name, mobile_phone,department,status FROM vw_employeedata ORDER BY id ASC;");
$header = $db->query("SHOW columns FROM Employees");

//display the headers for each cell
$pdf->SetWidths(array(10, 30, 30, 30, 30, 30, 30));
// for ($i = 0; $i < 1; $i++) {
$pdf->Row(array('ID', 'Employee ID', 'First Name', 'Middle Name', 'Last Name', 'Mobile Phone', 'Department'));
// }
// $pdf->Ln();
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10, 30, 30, 30, 30, 30, 30));


//display the data in each cell
foreach ($result as $row) {
	// $pdf->Ln();
	// foreach ($row as $column)
	$pdf->Row(array($row['id'], $row['employee_id'], $row['first_name'], $row['middle_name'], $row['last_name'], $row['mobile_phone'], $row['department']));
}

$pdf->Output();

exit;
