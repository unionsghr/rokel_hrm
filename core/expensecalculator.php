<?php

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$mysqli =  mysqli_connect("localhost", "root", "", "hrmdata");
    if (mysqli_connect_errno($mysqli)) {
        // echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
 

// Takes raw data from the request
$json = file_get_contents('php://input');
// echo $json;
// die();

// Converts it into a PHP object
$data = json_decode($json);

$currency = $data->currency;
$amount = $data->amount;
// $category = $data->category;


$sql = "SELECT (xcg_rate * '$amount') local_currency FROM `currencytypes` c WHERE code = '$currency' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);


$message = json_encode(
    array(
        "responseCode" => "000",
        "message" => "Calculated local cureency",
        "data"=> $row['local_currency']
        // "data1"=> $row_['expense_gl']
        
    )
    
);

exit($message);

