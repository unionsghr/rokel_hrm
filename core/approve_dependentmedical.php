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

// // Takes raw data from the request
$json = file_get_contents('php://input');

$data = json_decode($json);

$id = isset($data->id) ? $data->id : 0;
$currentUser = $data->currentUser;
// $id = '2';
$sql = "UPDATE dependentmedical set status = 'Approved', approved_date = CURRENT_DATE, approved_by = $currentUser where id = '$id'";

$result = mysqli_query($mysqli, $sql);
// $row = mysqli_fetch_assoc($result);

// echo json_encode($row); die();



$sql_ = "SELECT * from vw_dependentmedicals where id = '$id'";
$result_ = mysqli_query($mysqli, $sql_);
$row_ = mysqli_fetch_assoc($result_);

        $cust_account = $row_['account_no'];
        $employee_id = $row_['employee_id'];
        $narration = 'Dependent Medical Claim - ' . $employee_id;
        $amount = $row_['amount'];
        $documentRef = substr(base_convert(uniqid(sha1(mt_rand())), 16, 36), 0, 2) . time();  

$sql_gl = "SELECT salarycomponent_gl as general_ledger from payrollcolumns where name LIKE 'Medical%'";
$result_gl = mysqli_query($mysqli, $sql_gl);
$row_gl = mysqli_fetch_assoc($result_gl);
        $general_ledger = $row_gl['general_ledger'];

        echo "cust_account =>". $cust_account; "<br/>";
        echo "employee_id =>". $employee_id; "<br/>";
        echo "narration =>". $narration; "<br/>";
        echo "amount =>". $amount; "<br/>";
        echo "documentRef =>". $documentRef; "<br/>";
        echo "general_ledger =>". $general_ledger; "<br>";

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://10.93.121.144:9092/core/api/v1.0/account/'.$general_ledger.'/transfer',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => 'destinationAccountId='.$cust_account.'&amount='.$amount.'&documentRef='.$documentRef.'&narration='.$narration.'&postBy=UNIONADMIN&appBy=UG&customerTel=233206242008&transBy=USG&appBy=USG&=',
        CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'x-api-key: 20171411891',
        'x-api-secret: 141116517P',
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response;

        $sql_ref = "UPDATE dependentmedical set reference = '$documentRef',  api_response = '$response' where id = '$id'";
        $result_ref = mysqli_query($mysqli, $sql_ref);
        
        $message = json_encode(
            array(
                "responseCode" => "000",
                "message" => 'Successfully Approved and posted with reference No.: '.$documentRef,
                "data" => $response,
            )
        
        );
        
        exit($message);