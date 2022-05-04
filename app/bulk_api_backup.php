<?php
use Classes\IceResponse;

function payroll()
{
    // echo "This is bulk_api"; die();

    $mysqli = mysqli_connect("localhost", "root", "", "hrmdata");
    if (mysqli_connect_errno($mysqli)) {
        // echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $id = '78';
    // $id = $_POST['payroll_id_'];

    // echo $id; die();

    // $query = "SELECT payroll_item, amount, payroll, bank_acc_no, c.branch, posting_column, name FROM payrolldata a, payrollcolumns b, employees c WHERE a.payroll_item = b.id AND a.employee = c.id AND payroll = '$id' AND posting_column = 'Yes' AND name LIKE 'Net%'";
    $query = "SELECT distinct payroll_item, amount, payroll, bank_acc_no, c.branch, posting_column, name FROM payrolldata a, payrollcolumns b, employees c WHERE a.payroll_item = b.id AND a.employee = c.id AND payroll = '$id' AND posting_column = 'Yes'";


    $date_query = "SELECT * From payroll where id = '$id'";

    $date_res = mysqli_query($mysqli, $date_query);

    while ($row = mysqli_fetch_assoc($date_res)) {

      $pay_month = $row['pay_month'];
      $type = $row['type'];
        

        // echo $pay_month; die();
    }

    $res = mysqli_query($mysqli, $query);

    $documentRef = substr(base_convert(uniqid(sha1(mt_rand())), 16, 36), 0, 2) . time();
    $trans_ref = rand();
    $date_created = Date('Y-m-d');
    $account_number = $creditnet = $branch = array();
    while ($row = mysqli_fetch_assoc($res)) {

        $creditnet[] = $row['amount'];
        $account_number[] = $row['bank_acc_no'];
        $branch[] = $row['branch'];
        // $employer_nassit[] = $row['employer_nassit'];

    }

    $creditnet = array_merge($creditnet);
    $account_number = array_merge($account_number);
    $branch_code = array_merge($branch);
    // $employer_nassit = array_merge($employer_nassit);

    // echo json_encode($account_number). '<br>'; die();

    $data_count = (count($account_number));
    // echo json_encode($data_count); die();
    $i = 0;
    while ($i < $data_count) {
        // echo $debit_count; die();

        $credits = array();
        $credits_merge = array();
        while ($i < $data_count) {
            // echo $date_start. " to ". $date_end; die();
            $credit_merge[] = array_push($credits,
                array(
                    'creditAmount' => (round(($creditnet[$i]), 2)),
                    'creditAccount' => trim($account_number[$i]),
                    'creditCurrency' => 'SLL',
                    'creditNarration' => $type. " For " . $pay_month,
                    'creditProdRef' => 'NS_' . $trans_ref,
                    'creditBranch' => $branch_code[$i],
                )
            );
            $i++;
        }

    }

    // // $id = "72";
    // $id = isset($data->id)  ? $data->id : 0;

    // $sql_ = "UPDATE `payroll` SET `documentRef` = '$documentRef' WHERE `payroll`.`id` = '$id' ";

    // $result_ = mysqli_query($mysqli, $sql_);

// $query_cr = "SELECT payroll_item, amount, payroll, bank_acc_no, c.branch, posting_column, name FROM payrolldata a, payrollcolumns b, employees c WHERE a.payroll_item = b.id AND a.employee = c.id AND payroll = '$id' AND posting_column = 'Yes'";

    $query_cr = "SELECT payroll_item, SUM(amount) amount, payroll, c.branch, salarycomponent_gl, posting_column, name, payment_deduction FROM payrolldata a, payrollcolumns b, employees c WHERE a.payroll_item = b.id AND a.employee = c.id AND payroll = '$id' AND posting_column = 'Yes' AND payment_deduction = 'B002' AND posting_branch = '011' AND name not like 'Net%' GROUP BY salarycomponent_gl, name
    ";

    $res_cr = mysqli_query($mysqli, $query_cr);

// echo $date_start. " to ". $date_end; die();

    $comp_amount_cr = $creditnet = $account_number = $branch_code = $narration = array();
    while ($row = mysqli_fetch_assoc($res_cr)) {

        $creditnet[] = $row['amount'];
        $account_number[] = $row['salarycomponent_gl'];
        // $branch_code[] = $row['branch'];
        $narration[] = $row['name'];

    }

    $comp_amount_cr = array_merge($creditnet);
    $comp_type_cr = array_merge($narration);
    // $branch_cd = array_merge($branch_code);
    $account_number_cr = array_merge($account_number);

    // echo json_encode($comp_amount_cr); die();

    $d = 0;
    $credit_count = count($comp_type_cr);

    $i = 0;
    $creditdata = array();
    $creditdata_ = array();
    // $credits = array();
    while ($i < $credit_count) {

        $creditdata_[] = array_push($creditdata,
            array(
                'creditAmount' => (round(($comp_amount_cr[$i]), 2)),
                'creditAccount' => trim($account_number_cr[$i]),
                'creditCurrency' => 'SLL',
                'creditNarration' => $comp_type_cr[$i] . " For " . $pay_month,
                'creditProdRef' => 'NS_' . $trans_ref,
                'creditBranch' => '000',
            )
        );

        $i++;
    }

    $final_credits = array_merge($creditdata, $credits);

    // echo json_encode($final_credits); die();

    $query1 = "SELECT payroll_item, SUM(amount) amount, payroll, c.branch, salarycomponent_gl, posting_column, name, payment_deduction FROM payrolldata a, payrollcolumns b, employees c WHERE a.payroll_item = b.id AND a.employee = c.id AND payroll = '$id' AND posting_column = 'Yes' AND payment_deduction = 'B001' AND posting_branch = '022' GROUP BY payroll_item, c.branch, salarycomponent_gl
    ";

    $res1 = mysqli_query($mysqli, $query1);
    $debit_amount = $debit_narration = $debit_branch = $debit_gl = array();

    while ($row = mysqli_fetch_assoc($res1)) {

        $debit_amount[] = $row['amount'];
        $debit_narration[] = $row['name'];
        $debit_branch[] = $row['branch'];
        $debit_gl[] = $row['salarycomponent_gl'];
    }

    $comp_amount = array_merge($debit_amount);
    $comp_type = array_merge($debit_narration);
    $branch = array_merge($debit_branch);
    $g_ledger = array_merge($debit_gl);

// echo count($employer_nassit) . "<br>"; die();

    $d = 0;
    $debit_count = count($comp_amount);
    $amount = $type = $branch_cd = $gl = 0;

    $i = 0;
    $debitdata = array();
    $debitdata_ = array();
    while ($i < $debit_count) {

        $debitdata_[] = array_push($debitdata,
            array(
                'debitAmount' => (round(($comp_amount[$i]), 2)),
                'debitAccount' => $g_ledger[$i],
                'debitCurrency' => 'SLL',
                'debitNarration' => $comp_type[$i] . " For " . $pay_month,
                'debitProdRef' => 'BS_' . $trans_ref,
                'debitBranch' => $branch[$i],
            ));
        $i++;
    }

    $query_r = "SELECT payroll_item, SUM(amount) amount, payroll, c.branch, salarycomponent_gl, posting_column, name, payment_deduction FROM payrolldata a, payrollcolumns b, employees c WHERE a.payroll_item = b.id AND a.employee = c.id AND payroll = '$id' AND posting_column = 'Yes' AND payment_deduction = 'B001' AND posting_branch = '011' GROUP BY salarycomponent_gl
    ";
    $debit_amount_r = $debit_narration_r = $debit_branch_r = $debit_gl_r = array();
    $res_r = mysqli_query($mysqli, $query_r);

    while ($row = mysqli_fetch_assoc($res_r)) {

        $debit_amount_r[] = $row['amount'];
        $debit_narration_r[] = $row['name'];
        $debit_branch_r[] = $row['branch'];
        $debit_gl_r[] = $row['salarycomponent_gl'];
    }

    $comp_amount_r = array_merge($debit_amount_r);
    $comp_type_r = array_merge($debit_narration_r);
    $branch_r = array_merge($debit_branch_r);
    $g_ledger_r = array_merge($debit_gl_r);

// echo count($employer_nassit) . "<br>"; die();

    $d = 0;
    $debit_count_r = count($comp_amount_r);
// $amount = $type = $branch_cd = $gl = 0;

    $i = 0;
    $debitdata_ = array();
    $debitdata_br = array();
    while ($i < $debit_count_r) {

        $debitdata_br[] = array_push($debitdata_,
            array(
                'debitAmount' => (round(($comp_amount_r[$i]), 2)),
                'debitAccount' => $g_ledger_r[$i],
                'debitCurrency' => 'SLL',
                'debitNarration' => $comp_type_r[$i] . " For " . $pay_month,
                'debitProdRef' => 'BS_' . $trans_ref,
                'debitBranch' => '000',
            ));
        $i++;
    }

    $final_debits = array_merge($debitdata, $debitdata_);

// echo json_encode($final_debits); die();

    $data1 = array(
        'approvedBy' => 'Admin',
        'channelCode' => 'HRP',
        'transType' => "SAL",
        'debitAccounts' => $final_debits,
        'creditAccounts' => $final_credits,
        'referenceNo' => $documentRef,
        'postedBy' => 'BANKOWNER',

    );

    echo json_encode($data1); die();

    $myfile = fopen("Payroll_Report_" . $trans_ref . "_" . $date_created . ".txt", "w") or die("Unable to open file!");
    // $txt = "Mickey Mouse\n";
    // fwrite($myfile, $txt);
    $txt = json_encode($data1);
    fwrite($myfile, $txt);
    fclose($myfile);

    $myfile = fopen("Payroll_Report_" . $trans_ref . "_" . $date_created . ".json", "w") or die("Unable to open file!");
    // $txt = "Mickey Mouse\n";
    // fwrite($myfile, $txt);
    $txt = json_encode($data1);
    fwrite($myfile, $txt);
    fclose($myfile);

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://10.93.121.144:9092/core/api/v1.0/account/performBulkPayment",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "PUT",
        CURLOPT_POSTFIELDS => json_encode($data1),
        CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "x-api-key: 20171411891",
            "x-api-secret: 141116517P",
        ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);
// echo $response;
  // $res = json_decode($response);

    // echo "Account Number-> ".$res -> accountNumber. "Customer Number-> " .$res -> customerNumber;die();
    $posting_response = $res->message;
// return new IceResponse(IceResponse::SUCCESS, $response); die();

    $sql_ = "UPDATE `payroll` SET `documentRef` = '$documentRef', finalized_date = CURRENT_DATE, payment_log = '$posting_response' WHERE `payroll`.`id` = '$id' ";
    $result_ = mysqli_query($mysqli, $sql_);
}

function email()
    {

    $mysqli = mysqli_connect("localhost", "root", "", "hrmdata");
    if (mysqli_connect_errno($mysqli)) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $id = $_POST['payroll_id_'];
    // $query = "SELECT employees.*, salaries.* FROM employees, salaries where employees.id = salaries.employee";
    $query = "SELECT * FROM vw_final_salaries where payroll = '$id'";

    $employee_id = $first_name = $middle_name = $last_name = $bank_acc_no = $tin_no = $ssn_num = $nassit_num = $job_title = $pay_grade = $notch = $department = $branch = array();

    $res = mysqli_query($mysqli, $query);

    while ($row = mysqli_fetch_assoc($res)) {

        $employee_id[] = $row['employee_id'];
        $first_name[] = $row['first_name'];
        $middle_name[] = $row['middle_name'];
        $last_name[] = $row['last_name'];
        $bank_acc_no[] = $row['bank_acc_no'];
        // $tin_no[] = $row['tin_no'];
        $ssn_num[] = $row['NASSIT_NO'];
        // $nassit_num[] = $row['nassit_num'];
        // $job_title[] = $row['job_title'];
        $pay_grade[] = $row['pay_grade'];
        $notch[] = $row['notches'];
        // $department[] = $row['department'];
        $branch[] = $row['branch'];
        $payslip_no = substr(base_convert(uniqid(sha1(mt_rand())), 16, 36), 0, 2) . time();

        $basic[] = $row['basic'];
        $car[] = $row['car'];
        $honorarium[] = $row['honorarium'];
        $transport[] = $row['transport'];
        $lunch[] = $row['lunch'];
        $monthly_rent[] = $row['monthly_rent'];
        $total_allowance[] = $row['total_allowance'];
        $gross_salary[] = $row['gross_salary'];
        $nassit[] = $row['nassit_5'];
        $employer_nassit[] = $row['nassit10_deduct'];
        $medical_excess[] = $row['medical_excess'];
        $union_dues[] = $row['union_dues'];
        $paye[] = $row['paye'];
        $total_deduction[] = $row['total_deduction'];
        $net_salary[] = $row['net_salary'];
        $account_number[] = $row['bank_acc_no'];

    }

    // echo json_encode($employee_id); die();

    // echo count($employee_id); die();

    $date_query = "SELECT * From payroll where id = '$id'";

    $date_res = mysqli_query($mysqli, $date_query);

    while ($row = mysqli_fetch_assoc($date_res)) {

        $pay_month = $row['pay_month'];
        $report_name = $row['name'];
        // $date_end = $row['date_end'];
        # code...
    }
// ob_start();

    $emp_id = array_merge($employee_id);
    $f_name = array_merge($first_name);
    $m_name = array_merge($middle_name);
    $l_name = array_merge($last_name);
    $bank_acc = array_merge($bank_acc_no);
    $tin_number = array_merge($tin_no);
    $ssn_number = array_merge($ssn_num);
    $nassit_number = array_merge($nassit_num);
    $job_title_ = array_merge($job_title);
    $pay_grade_ = array_merge($pay_grade);
    $notch_ = array_merge($notch);
    $dept = array_merge($department);
    $branch_code = array_merge($branch);
    $basic_salary = array_merge($basic);
    $car_allowance = array_merge($car);
    $honorarium_allowance = array_merge($honorarium);
    $transport_allowance = array_merge($transport);
    $lunch_allowance = array_merge($lunch);
    $rent = array_merge($monthly_rent);
    $total_allowances = array_merge($total_allowance);
    $gross = array_merge($gross_salary);
    $employee_nassit = array_merge($nassit);
    $employer_nassit_ = array_merge($employer_nassit);
    $medical = array_merge($medical_excess);
    $dues = array_merge($union_dues);
    $paye_ = array_merge($paye);
    $deduction = array_merge($total_deduction);
    $net = array_merge($net_salary);
    $acct_number = array_merge($account_number);

// echo json_encode($emp_id); die();
    $data_count = (count($account_number));
    // echo json_encode($debit_count); die();
    // echo $data_count; die();

    $i = 0;

    while ($i < $data_count) {

// echo $branch_code[$i];

        $pdf = '

<head>

<link rel="stylesheet" href="styles.css">

</head>
<body>
  <div class="salary-slip" >
            <table class="empDetail">
              <tr height="100px" style="background-color: #c2d69b">
                <td colspan="4">
                  <img height="90px" src="logo.jpg" /></td>
                <td colspan="4" class="companyName">PAYSLIP </td>
              </tr>';
        $pdf .= '
              <tr>
                <th>
                  Employee Name:
      </th>
                <td>
                  ' . $first_name[$i] . " " . $middle_name[$i] . " " . $last_name[$i] . '

      </td>
                <td></td><td></td>
                <th>
                  Branch Code:
      </th>
                <td>
                  ' . $branch[$i] . '
      </td>
                <td></td><td></td>

             <tr>
                <th>
                  Employee ID:
      </th>
                <td>
                  ' . $employee_id[$i] . '
      </td>
                <td></td><td></td>

                <th>
                  Payslip no.:
      </th>
                <td>
                  ' . $payslip_no . '
      </td>
              </tr>
              <tr>
                <th>
                  Cost Centre:
      </th>
                <td>
                  ' . $department[$i] . '
      </td><td></td><td></td>

                <th>
                  Pay Period:
      </th>
                <td>
                  ' . $pay_month . '
      </td>
              </tr>
              <tr>
                <th>
                  NASSIT No.:
      </th>
                <td>
                  ' . $nassit_num[$i] . '
      </td><td></td><td></td>
                <th>
                  Bank A/C no.:
      </th>
                <td>
                  ' . $bank_acc_no[$i] . '
      </td><td></td><td></td>

              </tr>
              <tr>
                <th>
                  Pay Grade:
      </th>
                <td>
                  ' . $pay_grade[$i] . '
      </td><td></td><td></td>
                <th>
                  Notch:
      </th>
                <td>
                  ' . $notch[$i] . '
      </td>

              </tr>
              <tr class="myBackground">
                <th colspan="2">
                  Payments:
      </th>
                <th >

      </th>

                  <th style="text-align: right;">
                  Amount (SLL)
      </th>
                <th colspan="2">
                  Deductions
      </th>
                <th >

      </th>
                <th style="text-align: right;">
                  Amount (SLL)
      </th>
              </tr>
              <tr>
                <th colspan="2">
                  Basic Salary
      </th>
                <td></td>
                <td class="myAlign">
                  ' . number_format($basic[$i], 2) . '
      </td>
                <th colspan="2" >
                  Employer NASSIT
      </th >
                <td></td>

                <td class="myAlign">
                  ' . number_format($employer_nassit[$i], 2) . '
      </td>
              </tr >
              <tr>
                <th colspan="2">
                  Car Allowance
      </th>
                <td></td>

                <td class="myAlign">
                 ' . number_format($car[$i], 2) . '
      </td>
                <th colspan="2" >
                  Employee NASSIT
      </th >
                <td></td>

                <td class="myAlign">
                  ' . number_format($nassit[$i], 2) . '
      </td>
              </tr >
              <tr>
                <th colspan="2">
                  Honorarium
      </th>
                <td></td>

                <td class="myAlign">
                  ' . number_format($honorarium[$i], 2) . '
      </td>
                <th colspan="2" >
                  Medical Excess
      </th >
                <td></td>

                <td class="myAlign">
                  ' . number_format($medical_excess[$i], 2) . '
      </td>
              </tr >
              <tr>
                <th colspan="2">
                  Transport Allowance
      </th>
                <td></td>
                <td class="myAlign">
                  ' . number_format($transport[$i], 2) . '
      </td>
                <th colspan="2" >
                  PAYE
      </th >
                <td></td>
                <td class="myAlign">
                  ' . number_format($paye[$i], 2) . '
      </td>
              </tr >
              <tr>
                <th colspan="2">
                  Lunch Allowance
      </th>
                <td></td>

                <td class="myAlign">
                  ' . number_format($lunch[$i], 2) . '
      </td>
                <th colspan="2" >
                   Union Dues
      </th >
                <td></td>

                <td class="myAlign">
                  ' . number_format($union_dues[$i], 2) . '
      </td>
              </tr >
              <tr>
                <th colspan="2">
                  Monthly Rent
      </th> <td></td>
                <td class="myAlign">
                  ' . number_format($monthly_rent[$i], 2) . '
      </td>
              <tr class="myBackground">
                <th colspan="3">
                  Total Payments
      </th>
                <td class="myAlign">
                  ' . number_format($gross_salary[$i], 2) . '
      </td>
                <th colspan="3" >
                  Total Deductions
      </th >
                <td class="myAlign">
                  ' . number_format($total_deduction[$i], 2) . '
      </td>
              </tr >
              <tr height="40px">
                <th colspan="2">
                  <!-- Projection for Financial Year: -->
                </th>
                <th>
                </th>
                <td class="table-border-right">
                </td>
                <th colspan="2" class="table-border-bottom" >
                  Net Pay
                </th >
                <td >
                </td>
                <td class="myAlign">
                  ' . number_format($net_salary[$i], 2) . '
                </td>
              </tr >

            </table >

          </div >

        </body>';

// echo $pdf; die();

        file_put_contents('/xampp/htdocs/html/' . 'Payslip_' . $employee_id[$i] . '_' . $i . '.html', $pdf);

// file_put_contents('/xampp/htdocs/html/test.html', $pdf);

        $html_file_url = 'C:\xampp\htdocs\html\Payslip_' . $employee_id[$i] . '_' . $i . '.html'; // html file

// $html_file_url = 'C:\xampp\htdocs\payslip\payslip.php'; // html file

        $pdf_file_url = 'C:/xampp/htdocs/pdf/' . 'Payslip_' . $employee_id[$i] . '_' . $i . '.pdf'; // pdf file

// $pdf_file_url = 'C:/xampp/htdocs/pdf/test.pdf'; // pdf file

        $cmd = "C:\Users\User\wkhtmltox\bin\wkhtmltopdf -O landscape $html_file_url $pdf_file_url"; // command

// $cmd = "C:\>Users\User\wkhtmltox\bin\wkhtmltopdf C:\xampp\htdocs\test1.html 'C:/xampp/htdocs/pdf/test.pdf'"

        exec($cmd); // execute command from php

        $query = "SELECT users.*, vw_final_salaries.*  FROM  users, vw_final_salaries where users.employee = vw_final_salaries.employee AND payroll = '$id'";

        $res = mysqli_query($mysqli, $query);

        $email = $username = array();

        while ($row = mysqli_fetch_assoc($res)) {

            $email[] = $row['email'];
            $username[] = $row['username'];

        }

        $email = array_merge($email);
        $username = array_merge($username);

        $email_count = count($email);

        $i = 0;

        while ($i <= $email_count) {

            $final_email = $email[$i];
            $final_username = $username[$i];
            # code...
            $file = $pdf_file_url;
            $to_email = $final_email;
            $subject = "Rokel Monthly Payslip";
            $body = "Dear " . $final_username . "," . "

<p> Please be informed that your payslip for " . $pay_month . " is ready. Kindly download the attachment. </p>

<p> You can also Login to Download here: http://localhost/rokel_hr/app/?g=modules&n=reports&m=module_User_Reports </p>


<p> If you have any question, do not hesitate to contact HR. </p>

<p> Best Regards, </p>
<p> ROKEL HR. </p>

";
            $headers = "From: Rokel HR";
            $semi_rand = md5(time());
            $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

// Headers for attachment
            $headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\"";

// Multipart boundary
            $message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"UTF-8\"\n" .
                "Content-Transfer-Encoding: 7bit\n\n" . $body . "\n\n";

            // Preparing attachment
            if (!empty($file) > 0) {
                if (is_file($file)) {
                    $message .= "--{$mime_boundary}\n";
                    $fp = @fopen($file, "rb");
                    $data = @fread($fp, filesize($file));

                    @fclose($fp);
                    $data = chunk_split(base64_encode($data));
                    $message .= "Content-Type: application/octet-stream; name=\"" . basename($file) . "\"\n" .
                    "Content-Description: " . basename($file) . "\n" .
                    "Content-Disposition: attachment;\n" . " filename=\"" . basename($file) . "\"; size=" . filesize($file) . ";\n" .
                        "Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
                }
            }
            $message .= "--{$mime_boundary}--";

            if (mail($to_email, $subject, $message, $headers)) {
                echo "Email successfully sent to $to_email...";
            } else {
                echo "Email sending failed...";
            }
            $i++;
        }

    }

    $i++;
}

payroll();
// email();

header("Location:http://10.93.121.98/rokel_hrm/app/?g=admin&n=payroll&m=admin_Payroll");
