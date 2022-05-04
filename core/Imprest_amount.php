<?php

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$mysqli =  mysqli_connect("localhost", "root", "", "hrmdatatest_utb");
    if (mysqli_connect_errno($mysqli)) {
        // echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }


// Takes raw data from the request
$json = file_get_contents('php://input');
// echo $json;
// die(); 

// Converts it into a PHP object
$data = json_decode($json);

$ref_no = $data->imp_code;

$sql = "SELECT (local_eqv) FROM employeetravelrecords WHERE ref_no = '$ref_no' ";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);

$message = json_encode(
    array(
        "responseCode" => "000",
        "message" => "Imprest Amount",
        "data"=> $row['local_eqv']
        
    )
    
);

exit($message);

