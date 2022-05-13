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
$pdf->Cell(100, 6, 'SUSPENDED EMPLOYEE LIST', 0, 0, 'C');
$date = date("Y-m-d");
// $pdf->Cell(100, 6, 'Employee Certificate List', 1, 0, 'C');
$pdf->Cell(13, 7, 'Print date:', 0);
$pdf->Cell(15, 7, $date, 0);
// $pdf->Cell(30, $date, 1, 0, 'C');
// Line break
$pdf->Ln(10);



//file headers
$display_heading = array(
  'vw_employeedata.id' => 'ID', 'first_name' => 'First name', 'middle_name' => 'Middle name', 'last_name' => 'Last name', 'mobile_phone' => 'Mobile phone', 'description' => 'Description', 'gender' => 'Gender', 'status'=>'Status', 'supervisor'=>'Supervisor'
);

//script for generating pdf
$result = $db->query("SELECT vw_employeedata.id, vw_employeedata.first_name, vw_employeedata.middle_name,vw_employeedata.last_name,vw_employeedata.mobile_phone,companystructures.description,vw_employeedata.gender,vw_employeedata.status, concat(employees.first_name,' ',employees.last_name) supervisor from vw_employeedata,employees,companystructures where vw_employeedata.status = 'Suspended' and employees.id = vw_employeedata.supervisor and vw_employeedata.department = companystructures.id;");
$header = $db->query("SHOW columns FROM Certificate");

//display the headers for each cell
$pdf->SetWidths(array(10, 25, 25, 25, 25, 20, 15,20,20));
// for ($i = 0; $i < 1; $i++) {
$pdf->Row(array('ID', 'First name', 'Middle name', 'Last name', 'Mobile phone', 'Description','Gender','Status','Supervisor'));
// }
// $pdf->Ln();
//Table with 20 rows and 4 columns
$pdf->SetWidths(array(10, 25, 25, 25, 25, 20, 15,20,20));


//display the data in each cell
foreach ($result as $row) {
  // $pdf->Ln();
  // foreach ($row as $column)
  $pdf->Row(array($row['id'], $row['first_name'], $row['middle_name'], $row['last_name'], $row['mobile_phone'], $row['description'], $row['gender'], $row['status'], $row['supervisor'],));
}

$pdf->Output();

exit;
