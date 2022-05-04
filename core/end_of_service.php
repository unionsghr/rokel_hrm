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

// Converts it into a PHP object
$data = json_decode($json);

$employee_id = $data->employee_id;
    $sql1 = "UPDATE employees set status = 'Terminated', termination_status = 'Approved' where id = $employee_id";
    $result1 = mysqli_query($mysqli, $sql1);
    $row = mysqli_fetch_assoc($result1);

    $sql = " SELECT * from vw_end_of_serv_benefits where years_of_service BETWEEN min_yrs_of_service AND max_yrs_of_service AND id = $employee_id";
    $result = mysqli_query($mysqli, $sql);
    $row = mysqli_fetch_assoc($result);

        $cust_account = $row['bank_acc_no'];
        $description = $row['description'];
        $general_ledger = $row['general_ledger'];
        $amount = $row['amount'];
        $documentRef = substr(base_convert(uniqid(sha1(mt_rand())), 16, 36), 0, 2) . time();  

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://192.168.1.225:8680/core/api/v1.0/account/'.$general_ledger.'/transfer',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS => 'destinationAccountId='.$cust_account.'&amount='.$amount.'&documentRef='.$documentRef.'&narration='.$description.'&postBy=UNIONADMIN&appBy=UG&customerTel=233206242008&transBy=USG&appBy=USG&=',
        CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
        'x-api-key: 20171411891',
        'x-api-secret: 141116517P',
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        // echo $response; 

        $message = json_encode(
            array(
                "responseCode" => "000",
                "message" => "End of Service Benefit",
                "data" => $response
                // "data1"=> $row_['expense_gl']
        
            )
        
        );
        
        exit($message);



