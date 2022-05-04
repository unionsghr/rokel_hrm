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
$sql = "UPDATE staffmedical set status = 'Submitted' where status = 'Draft' AND id = '$id'";

$sql_ = "SELECT * FROM vw_staffmedicals where emp_status = 'Active' AND id = '$id'";

$res_ = mysqli_query($mysqli, $query_bank);
while ($row = mysqli_fetch_assoc($res_)) {

    $id = $row['id'];
    $employee = $row['employee'];
    $from_date = $row['from_date'];
    $to_date = $row['to_date'];
    $admission_type = $row['admission_type'];
    $type_of_illness = $row['type_of_illness'];
    $medication_given = $row['medication_given'];    
    $cost = $row['cost'];
    $hospital = $row['hospital'];
    $physician = $row['physician'];
    $med_status = $row['med_status'];
    $employee_id = $row['employee_id'];
    $first_name = $row['first_name'];
    $middle_name = $row['middle_name'];
    $last_name = $row['last_name'];
    $bank_acc_no = $row['bank_acc_no'];
    $staff_level = $row['staff_level'];
    $employment_status = $row['employment_status'];
    $job_title = $row['job_title'];
    $grade = $row['grade'];
    $address1 = $row['address1'];
    $address2 = $row['address2'];
    $city = $row['city'];
    $home_phone = $row['home_phone'];
    $mobile_phone = $row['mobile_phone'];
    $work_phone = $row['work_phone'];
    $work_email = $row['work_email'];
    $private_email = $row['private_email'];
    $supervisor_email = $row['supervisor_email'];
    $supervisor_name = $row['supervisor_name'];
    $department = $row['department'];
    $branch = $row['branch'];
    $emp_status = $row['emp_status'];
}


$to = $supervisor_email;
$subject = "XHRM - Medical Expense";

$message = "
Dear ". $supervisor_name . ", 
You have medical expense from your subordinate pending your approval. <br/><br/>

<b>Details:</b><br/><br/>


 
"
;

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <paulgyidana@gmail.com>' . "\r\n";
// $headers .= 'Cc: pygeorge@st.ug.edu.gh' . "\r\n";

mail($to,$subject,$message,$headers);
    





$result = mysqli_query($mysqli, $sql);

        $message = json_encode(
            array(
                "responseCode" => "000",
                "message" => 'Successfully Submitted',
                "data" => $response,
            )
        
        );
        
        exit($message);