<?php


function payroll(){
  
  // echo "gets here"; die();

    $mysqli = mysqli_connect("localhost", "root", "", "hrmdata");
    if (mysqli_connect_errno($mysqli)) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();

    }
   
    
    $res = mysqli_query($mysqli, "SELECT * FROM new_salaries WHERE id ='1'");
    $row = mysqli_fetch_assoc($res);

    // $employee_count = mysqli_query("SELECT count(*) FROM salaries");

                    $employee =  $row['employee'];
                    $account_no = $row['account_no'];
                    $basic_salary = $row['basic_salary'];
                    $car_allowance = $row['car_allowance'];
                    $honorarium = $row['honorarium'];
                    $transport = $row['transport'];
                    $lunch = $row['lunch'];   
                    $monthly_rent = $row['monthly_rent'];
                    $nassit = $row['nassit'];
                    $medical_excess = $row['medical_excess'];
                    $union_dues = $row['union_dues'];
                    $paye = $row['paye'];
                    $gross_salary = $row['gross_salary'];
                    $net_salary = $row['net_salary'];
                    $date_created = $row['date_created'];
    
     // LogManager::getInstance()->info($employee ." ". $exp_gl ." ".$transaction_no ." ". $payee ." ". $amount ." ". $notes);

      echo ("Employee =>".$employee ." "."Account Number =>"." ".$account_no ." "." Basic Salary => ". $basic_salary ." "."Car Allowance => ".$car_allowance ." "." Honorarium =>". $honorarium ." "."Transport =>". $transport ." "."Lunch =>". $lunch ." "."Monthly Rent =>". $monthly_rent ." "."NASSIT =>". $nassit ." "."Medical Excess =>".$medical_excess ." "."Union Dues =>". $union_dues ." "."PAYE =>". $paye ." "."Gross Salary =>". $gross_salary ." "."Net Salary =>". $net_salary ." "."Date Created =>". $date_created);
    
//      header("Location:http://localhost/USG_HR/app/?g=admin&n=payroll&m=admin_Payroll"); 




$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_PORT => "8680",
  CURLOPT_URL => "http://192.168.1.225:8680/core/api/v1.0/account/004008110815520173/transfer",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "PUT",
  CURLOPT_POSTFIELDS => "destinationAccountId=$account_no&amount=$basic_salary&documentRef=$date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
  CURLOPT_HTTPHEADER => array(
    "Accept: */*",
    "Accept-Encoding: gzip, deflate",
    "Cache-Control: no-cache",
    "Connection: keep-alive",
    "Content-Length: 159",
    "Content-Type: application/x-www-form-urlencoded",
    "Host: 192.168.1.225:8680",
    "Postman-Token: 0d6be1f0-8f8e-4861-8161-81b2b1691925,5a98c7da-f505-43fd-9371-f6cc5777893a",
    "User-Agent: PostmanRuntime/7.20.1",
    "cache-control: no-cache",
    "x-api-key: 20171411891",
    "x-api-secret: 141116517"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

           }

payroll();
      


// header("Location:http://localhost/utb_hr/app/?g=admin&n=payroll&m=admin_Payroll");



?>