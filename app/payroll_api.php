<?php

function payroll(){
  
  // echo "gets here"; die();

    $mysqli = mysqli_connect("localhost", "root", "", "hrmdata");
    if (mysqli_connect_errno($mysqli)) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();

    }
     
    $res = mysqli_query($mysqli, "SELECT * FROM salaries ");

    // $basic = mysqli_query($mysqli, "SELECT salarycomp_gl FROM salarycomponent WHERE id = '1'");
    // $car = mysqli_query($mysqli, "SELECT salarycomp_gl FROM salarycomponent WHERE id = '2'");
    // $hon= mysqli_query($mysqli, "SELECT salarycomp_gl FROM salarycomponent WHERE id = '3'");
    // $medical = mysqli_query($mysqli, "SELECT salarycomp_gl FROM salarycomponent WHERE id = '4'");
    // $dues = mysqli_query($mysqli, "SELECT salarycomp_gl FROM salarycomponent WHERE id = '5'");
    // $trans = mysqli_query($mysqli, "SELECT salarycomp_gl FROM salarycomponent WHERE id = '13'");
    // $lunch_1 = mysqli_query($mysqli, "SELECT salarycomp_gl FROM salarycomponent WHERE id = '14'");
    // $rent = mysqli_query($mysqli, "SELECT salarycomp_gl FROM salarycomponent WHERE id = '15'");
    // $nassit_1 = mysqli_query($mysqli, "SELECT salarycomp_gl FROM salarycomponent WHERE id = '16'");
    // $paye_1 = mysqli_query($mysqli, "SELECT salarycomp_gl FROM salarycomponent WHERE id = '17'");
    // $gross = mysqli_query($mysqli, "SELECT salarycomp_gl FROM salarycomponent WHERE id = '18'");
    // $net = mysqli_query($mysqli, "SELECT salarycomp_gl FROM salarycomponent WHERE id = '19'");

// $api_url = "http://192.168.1.225:8680/core/api/v1.0/account/$account_no/transfer"; 
    // $test = mysqli_fetch_assoc($basic)
    
    // echo $test; die();
    
    while ($row = mysqli_fetch_assoc($res)) {                

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
                    $ref_date_created = $date_created;

                    $api_url = "http://192.168.1.225:8680/core/api/v1.0/account/$account_no/transfer"; 

                    $postBy = "USG";
                    $appBy = "USG";
                    $transBy = "USG";
                    $customerTel = "00000";

                    $narration_basic = ' Basic Salary';
                    $narration_car =  ' Car Allowance';
                    $narration_hon =  ' Honorarium';
                    $narration_trans = ' Transport';
                    $narration_lunch = ' Lunch';
                    $narration_rent = ' Month Rent';
                    $narration_nassit = ' NASSIT Contribution';
                    $narration_medical = ' Medical Excess';
                    $narration_dues = ' Union Dues';
                    $narration_paye = ' PAYE';
                    $narration_gross = ' Gross Salary';
                    $narration_net = ' Net Salary';

                    $basic_gl ='143000000001';
                    $car_gl = '143000000002';
                    $honorarium_gl = '143000000007';
                    $transport_gl = '143000000006';
                    $lunch_gl = '143000000009';
                    $rent_gl = '143000000005';
                    $nassit_gl = '143000000007';
                    $medical_gl = '143000000003';
                    $dues_gl = '143000000012';
                    $paye_gl = '143000000013';
                    $gross_gl = '143000000011';
                    $net_gl = '143000000014';

                    // if ($basic_salary < 0){

                    //   basic;
                    // }

                BasicCall($api_url, $basic_gl, $basic_salary, $ref_date_created, $narration_basic, $postBy, $appBy, $transBy, $customerTel);

                CarCall($api_url, $car_gl, $car_allowance, $ref_date_created, $narration_car, $postBy, $appBy, $transBy, $customerTel);

                HonCall($api_url, $honorarium_gl, $honorarium, $ref_date_created, $narration_hon, $postBy, $appBy, $transBy, $customerTel);

                TransportCall($api_url, $transport_gl, $transport, $ref_date_created, $narration_trans, $postBy, $appBy, $transBy, $customerTel);

                LunchCall($api_url, $lunch_gl, $lunch, $ref_date_created, $narration_lunch, $postBy, $appBy, $transBy, $customerTel);

                RentCall($api_url, $rent_gl, $monthly_rent, $ref_date_created, $narration_rent, $postBy, $appBy, $transBy, $customerTel);

                NassitCall($api_url, $nassit_gl, $nassit, $ref_date_created, $narration_nassit, $postBy, $appBy, $transBy, $customerTel);

                MedicalCall($api_url, $medical_gl, $medical_excess, $ref_date_created, $narration_medical, $postBy, $appBy, $transBy, $customerTel);

                DuesCall($api_url, $dues_gl, $union_dues, $ref_date_created, $narration_dues, $postBy, $appBy, $transBy, $customerTel);

                PayeCall($api_url, $paye_gl, $paye, $ref_date_created, $narration_paye, $postBy, $appBy, $transBy, $customerTel);

                GrossCall($api_url, $gross_gl, $gross_salary, $ref_date_created, $narration_gross, $postBy, $appBy, $transBy, $customerTel);

                NetCall($api_url, $net_gl, $net_salary, $ref_date_created, $narration_net, $postBy, $appBy, $transBy, $customerTel);

    }

  
      // echo ("Net Salary =>"." ".$test1." "."Employee =>".$employee ." "."Account Number =>"." ".$account_no ." "." Basic Salary => ". $basic_salary ." "."Car Allowance => ".$car_allowance ." "." Honorarium =>". $honorarium ." "."Transport =>". $transport ." "."Lunch =>". $lunch ." "."Monthly Rent =>". $monthly_rent ." "."NASSIT =>". $nassit ." "."Medical Excess =>".$medical_excess ." "."Union Dues =>". $union_dues ." "."PAYE =>". $paye ." "."Gross Salary =>". $gross_salary ." "."Net Salary =>". $net_salary ." "."Date Created =>". $date_created);
    
               
           }

payroll();
      


// header("Location:http://localhost/utb_hr/app/?g=admin&n=payroll&m=admin_Payroll");


  function BasicCall($api_url, $basic_gl, $basic_salary, $ref_date_created, $narration_basic, $postBy, $appBy, $transBy, $customerTel){

if ($basic_salary <= 0 ){
  
  goto end;

}else{
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_PORT => "8680",
      CURLOPT_URL => $api_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => "destinationAccountId=$basic_gl&amount=$basic_salary&documentRef=$ref_date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
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
  end:
               }
    


function CarCall($api_url, $car_gl, $car_allowance, $ref_date_created, $narration_car, $postBy, $appBy, $transBy, $customerTel){

  if($car_allowance <= 0){

    // echo "Amount less than or equal to 0.00";
  goto end;
  }else{

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_PORT => "8680",
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => "destinationAccountId=$car_gl&amount=$car_allowance&documentRef=$ref_date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
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
end:
  }


  function HonCall($api_url, $honorarium_gl, $honorarium, $ref_date_created, $narration_hon, $postBy, $appBy, $transBy, $customerTel){

if($honorarium <= 0){
  goto end;
}else{
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_PORT => "8680",
      CURLOPT_URL => $api_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => "destinationAccountId=$honorarium_gl&amount=$honorarium&documentRef=$ref_date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
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
    end:
  }

    function TransportCall($api_url, $transport_gl, $transport, $ref_date_created, $narration_trans, $postBy, $appBy, $transBy, $customerTel){

      if($transport <= 0){
        goto end;
      }else{

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_PORT => "8680",
        CURLOPT_URL => $api_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => "destinationAccountId=$transport_gl&amount=$transport&documentRef=$ref_date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
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
      end:
  }


  function LunchCall($api_url, $lunch_gl, $lunch, $ref_date_created, $narration_lunch, $postBy, $appBy, $transBy, $customerTel){

    if($lunch <= 0){
      goto end;
    }else{
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_PORT => "8680",
      CURLOPT_URL => $api_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => "destinationAccountId=$lunch_gl&amount=$lunch&documentRef=$ref_date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
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
    end:
  }


function RentCall($api_url, $rent_gl, $monthly_rent, $ref_date_created, $narration_rent, $postBy, $appBy, $transBy, $customerTel){

if($monthly_rent <= 0){
  goto end;
}else{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_PORT => "8680",
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => "destinationAccountId=$rent_gl&amount=$monthly_rent&documentRef=$ref_date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
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
  end:

  }


  function NassitCall($api_url, $nassit_gl, $nassit, $ref_date_created, $narration_nassit, $postBy, $appBy, $transBy, $customerTel){

    if($nassit <= 0){
      goto end;
    }else{
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_PORT => "8680",
      CURLOPT_URL => $api_url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => "destinationAccountId=$nassit_gl&amount=$nassit&documentRef=$ref_date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
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
    end:
  }


function MedicalCall($api_url, $medical_gl, $medical_excess, $ref_date_created, $narration_medical, $postBy, $appBy, $transBy, $customerTel){

if($medical_excess <= 0){
  goto end;
}else{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_PORT => "8680",
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => "destinationAccountId=$medical_gl&amount=$medical_excess&documentRef=$ref_date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
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
  end:
  }


function DuesCall($api_url, $dues_gl, $union_dues, $ref_date_created, $narration_dues, $postBy, $appBy, $transBy, $customerTel){

if($union_dues <= 0){
  goto end;
}else{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_PORT => "8680",
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => "destinationAccountId=$dues_gl&amount=$union_dues&documentRef=$ref_date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
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
end:
  }

function PayeCall($api_url, $paye_gl, $paye, $ref_date_created, $narration_paye, $postBy, $appBy, $transBy, $customerTel){

if($paye <= 0){
  goto end;
}else{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_PORT => "8680",
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => "destinationAccountId=$paye_gl&amount=$paye&documentRef=$ref_date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
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
end:
  }


function GrossCall($api_url, $gross_gl, $gross_salary, $ref_date_created, $narration_gross, $postBy, $appBy, $transBy, $customerTel){

if($gross_salary <= 0){
  goto end;
}else{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_PORT => "8680",
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => "destinationAccountId=$gross_gl&amount=$gross_salary&documentRef=$ref_date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
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
end:
  }


function NetCall($api_url, $net_gl, $net_salary, $ref_date_created, $narration_net, $postBy, $appBy, $transBy, $customerTel){

if($net_salary <= 0){
  goto end;
}else{
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_PORT => "8680",
    CURLOPT_URL => $api_url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => "destinationAccountId=$net_gl&amount=$net_salary&documentRef=$ref_date_created&narration=dfh&postBy=UNIONADMIN&appBy=UG&appBy=USG&customerTel=233206242008&transBy=USG",
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
end:
  }
  header("Location:http://localhost/utb_hr/app/?g=admin&n=payroll&m=admin_Payroll");
  
?>