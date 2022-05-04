<?php

$mysqli = mysqli_connect("localhost", "root", "", "hrmdata");
if (mysqli_connect_errno($mysqli)) {
    // echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

$query = "SELECT * from vw_empsal_medicalbalance";
   
    $res = mysqli_query($mysqli, $query);

    while ($row = mysqli_fetch_assoc($res)) {
        $employee[] = $row['employee'];
        $medical_balance[] = $row['medical_balance'];
    }

    $emp = array_merge($employee);
    $balance = array_merge($medical_balance);

    // echo json_encode($emp);
    // echo json_encode($balance);die();
    $data_count = (count($emp)); 

    // echo $data_count; die();

    $i = 0;

    while ($i < $data_count) {
        // if($balance[$i] < 0){

            // echo $balance[$i];

            $sql = "UPDATE employeesalary set amount_temp = '$balance[$i]' where component = '4' AND employeesalary.employee = '$emp[$i]'";
            $result = mysqli_query($mysqli, $sql);
            // $row = mysqli_fetch_assoc($result);
        // } 
        $i++;
    }




