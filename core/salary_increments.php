<?php

header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$mysqli = mysqli_connect("localhost", "root", "", "hrmdata");
if (mysqli_connect_errno($mysqli)) {
    // echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// Takes raw data from the request
$json = file_get_contents('php://input');
// echo $json;
// die();

// Converts it into a PHP object
$data = json_decode($json);

$component = $data->component;
$status = $data->status;
$percentage_change = $data->percentage_change;

// if($component == '' ) {
//     $sql = " INSERT INTO salaries (component) values ('All Notches')";
//     $result = mysqli_query($mysqli, $sql);
//     $row = mysqli_fetch_assoc($result);

// }

if ($status == 'Increment' AND $component != NULL) {
        $sql = " UPDATE notches SET amount = ((amount*($percentage_change/100))+amount) WHERE id = $component";
        $result = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_assoc($result);
    
    } elseif ($status == 'Decrement' AND $component != NULL) {
        $sql = " UPDATE notches SET amount = (amount - (amount*($percentage_change/100))) WHERE id = $component";
        $result = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_assoc($result);

    } 
    elseif ($status == 'Increment' AND $component == NULL) {
        $sql = " UPDATE notches SET amount = ((amount*($percentage_change/100))+amount), component = 'All Notches'";
        $result = mysqli_query($mysqli, $sql);
        $row = mysqli_fetch_assoc($result);
    }
    else {
        // echo ("Undefined");
        exit(json_encode([
            'responseCode' => "999",
            "message" => "Status not identified",
            "data" => NULL
        ]));
    }

   
$message = json_encode(
    array(
        "responseCode" => "000",
        "message" => "Calculated local cureency",
        "data" => $row['local_currency'],
        // "data1"=> $row_['expense_gl']

    )

);

exit($message);
