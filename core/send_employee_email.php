<?php
header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json; charset=UTF-8");
header('Access-Control-Allow-Methods: POST');
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$mysqli = mysqli_connect("localhost", "root", "", "hrmdata");
if (mysqli_connect_errno($mysqli)) {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);

$employee_id = $data->employee_id;


//select employee
$sql = "select first_name, work_email,private_email FROM employees where id = '$employee_id';";
$result = mysqli_query($mysqli, $sql);
$row = mysqli_fetch_assoc($result);
// print($employee_id);
// die();

//get the message,department and attachment
$firstname = $row['first_name'];
$work_email = $row['work_email'];
$private_email = $row['private_email'];

// echo($work_email);
// echo($private_email);
// die();



// Email body content 
$htmlContent = ' 
    <h3>Dear '.$firstname.',</h3> 
    <p>You have been terminated as employee with this company.</p> 
';


$headers = "From: HR - UNION SYSTEMS GLOBAL Ltd";

// Boundary  
$semi_rand = md5(time());
$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

// Headers for attachment  
$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

// Multipart boundary  
$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
  "Content-Transfer-Encoding: 7bit\n\n" . $htmlContent . "\n\n";  


 


//if both work email and private email use the private email else use the available one
if (isset($work_email) && isset($private_email)) {

  $email = $private_email;
  $subject = "Employee termination";
  if (mail($email, $subject, $message,$headers)) {
    $message_code = "111";
  } else {
    $message_code = "000";
  }
} elseif (isset($work_email)) {
  $email = $work_email;
  $subject = "Employee termination";
  if (mail($email, $subject, $message,$headers)) {
    $message_code = "111";
  } else {
    $message_code = "000";
  }
} elseif(isset($private_email)) {
  $email = $private_email;
  $subject = "Employee termination";
  if (mail($email, $subject, $message,$headers)) {
    $message_code = "111";
  } else {
    $message_code = "000";
  }
}else{
  $message_code = "222";
}



$message = json_encode(
  array(
    "responseCode" => $message_code

  )

);

exit($message);
