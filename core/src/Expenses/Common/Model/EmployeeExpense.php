<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 12:10 PM
 */
namespace Expenses\Common\Model;

use Classes\SettingsManager;
use Model\ApproveModel;
use Utils\LogManager;
use Classes\BaseService;
use Classes\IceConstants;
use Classes\IceResponse;
use Classes\StatusChangeLogManager;
use Model\BaseModel;

class EmployeeExpense extends ApproveModel
{
    public $table = 'EmployeeExpenses';
    public $notificationModuleName = "Expense Management";
    public $notificationUnitName = "Expense";
    public $notificationUnitPrefix = "An";
    public $notificationUnitAdminUrl = "g=modules&n=expenses&m=module_Finance#tabSubordinateEmployeeExpense";
    public $preApproveSettingName = "Expense: Pre-Approve Expenses";

    public function isMultiLevelApprovalsEnabled()
    {
        return (SettingsManager::getInstance()->getSetting('Expense: Enable Multi Level Approvals') == '1');
    }


    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }

    public function getManagerAccess()
    {
        if ($this->status == 'Pending') {
            return array("element","save","delete");
        }

        return array("get","element","save");
    }

    public function getUserAccess()
    {
        return array("get");

    }

    public function getUserOnlyMeAccess()
    {
        if ($this->status == 'Pending') {
            return array("get","element","save","delete");
        }

        return array("get","element","save");
    }

    public function fieldsNeedToBeApproved()
    {
        return array(
            "employee",
            "amount",
            "category",
            "payment_method",
            "currency"
        );  

    }

 
    public function apiexpensedata($employee_id){

    LogManager::getInstance()->info("=====SALARIES ID ====>". $employee_Id ."<======" );

  // echo "gets here"; die();

    $mysqli = mysqli_connect("localhost", "root", "", "hrmdata");
    if (mysqli_connect_errno($mysqli)) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    

    // $res = mysqli_query($mysqli, "SELECT employeeexpenses.*, employees.bank_acc_no, companystructures.comp_code  FROM employeeexpenses, employees, companystructures where employees.id=employeeexpenses.employee AND companystructures.id = employeeexpenses.posting_branch AND employeeexpenses.id = '$employee_id' AND employeeexpenses.status != 'Approved'");
    $res = mysqli_query($mysqli, "SELECT * FROM employeeexpenses where employeeexpenses.id = '$employee_id' AND employeeexpenses.status != 'Approved' AND employeeexpenses.app_type = 'EXP'");   
    
    $row = mysqli_fetch_assoc($res);
    // echo $row['_msg'];
    
                    $employee =  $row['employee'];
                    // $exp_gl = $row['exp_gl'];
                    $transaction_no = $row['ref_no'];                    
                    $amount = $row['amount'];
                    $description = $row['description']; 
                    // $category = $row['category']; 
                    $cust_account = $row['emp_acc_no'];
                    $branch = $row['branch'];
                    $Imprest_amount = $row['imprest_amount'];
                    $Imprest_gl = $row['imprest_gl']; 
                    $items = json_decode($row['items']);
                    $documentRef = substr(base_convert(uniqid(sha1(mt_rand())), 16, 36), 0, 2) . time();

                    // echo $cust_account; die();
                    
    //  LogManager::getInstance()->info($employee ." ". $exp_gl ." ".$transaction_no ." ". $payee ." ". $amount ." ". $notes);
    
        // echo $employee." ".$exp_gl." ".$transaction_no." ".$payee." ".$amount." ".$notes; die();

        // echo $branch; die();
        $sql_ = "UPDATE `employeeexpenses` SET `documentRef` = '$documentRef' WHERE `employeeexpenses`.`id` = '$employee_id' ";

        $result_ = mysqli_query($mysqli, $sql_);


        $debitdata = array();
        $debitdata_ = array();
        $debit_amount = 0;

foreach ($items as $item) {
    // print_r($item);
    $expense_gl = $item->expense_gl;
    $debit_amount = $item->local_equivalent;
    $narration = $item->notes;
    $currency = $item->currency;
    // $transaction_no = $item->local_equivalent;


    $debitdata_[] = array_push($debitdata,
        array(              
              'debitAmount'=> (round(($debit_amount), 2)),
              'debitAccount' => $expense_gl,
              'debitCurrency' => 'SLL',
              'debitNarration' => $narration,
              'debitProdRef' => $transaction_no,
              'debitBranch' => $branch
              )
        );
}

// echo json_encode($debitdata); die(); 

// echo $total_sum; die();

      

        $creditdata[] =
      array(              
      'creditAmount'=> (round(($amount), 2)),
      'creditAccount' => $cust_account,
      'creditCurrency' => 'SLL',
      'creditNarration' => $description,
      'creditProdRef' => $transaction_no,
      'creditBranch' => $branch
      );


// $debitdata = $items;
        
        $data1 = array(
          'approvedBy' => 'Admin',
          'channelCode' => 'HRP',
          'transType'=> "SAL",
          'debitAccounts' => $debitdata,
          'creditAccounts' => $creditdata,
          'referenceNo'=> $documentRef,
          'postedBy' => 'USG'

  );

//   echo json_encode($data1); die();

        // echo $items; die();

        LogManager::getInstance()->info($employee ." ". $expense_gl ." ".$transaction_no ." ". $narration ." ". $amount ." ". $notes);
    

          
    //     $curl = curl_init();

    //     curl_setopt_array($curl, array(
    //     CURLOPT_URL => "http://192.168.1.225:8680/core/api/v1.0/account/performBulkPayment",
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => "",
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 0,
    //     CURLOPT_FOLLOWLOCATION => true,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => "PUT",
    //     CURLOPT_POSTFIELDS =>json_encode($data1),
    //     CURLOPT_HTTPHEADER => array(
    //       "Content-Type: application/json",
    //       "x-api-key: 20171411891",
    //       "x-api-secret: 141116517P"
    //     ),
    //   ));
      
    //   $response = curl_exec($curl);
      
    //   curl_close($curl);
    //   echo $response;

      if ($Imprest_amount != NULL){

        $curl = curl_init();
    
        curl_setopt_array($curl, array(
          CURLOPT_URL => "http://10.93.121.144:9092/core/api/v1.0/account/$cust_account/transfer",
        // http://10.93.121.144:9092/core/api/v1.0/account/:accountId/transfer
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "PUT",
          CURLOPT_POSTFIELDS => "destinationAccountId=$Imprest_gl&amount=$Imprest_amount&documentRef=$transaction_ref&narration=$description&postBy=UNIONADMIN&appBy=UG&customerTel=233206242008&transBy=USG&appBy=USG",
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/x-www-form-urlencoded",
            "x-api-key: 20171411891",
            "x-api-secret: 141116517P"
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);

      }

      

           }


    public function getType()
    {
        return 'EmployeeExpense';
    }

    public function allowIndirectMapping()
    {
        if (SettingsManager::getInstance()->getSetting('Expense: Allow Indirect Admins to Approve') == '1') {
            return true;
        }
        return false;
    }
}
