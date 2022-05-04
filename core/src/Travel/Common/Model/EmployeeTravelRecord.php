<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/20/17
 * Time: 8:05 AM
 */

namespace Travel\Common\Model;

use Classes\SettingsManager;
use Model\ApproveModel;
use Utils\LogManager;
use Classes\BaseService;
use Classes\IceConstants;
use Classes\IceResponse;
use Classes\StatusChangeLogManager;
use Model\BaseModel;

    class EmployeeTravelRecord extends ApproveModel
{
    
    public $table = 'EmployeeTravelRecords';

    public $notificationModuleName = "Imprest Management";
    public $notificationUnitName = "Imprest Request";
    public $notificationUnitPrefix = "A";
    public $notificationUnitAdminUrl
        = "g=modules&n=travel&m=module_Travel_Management#tabSubordinateEmployeeTravelRecord";
    public $preApproveSettingName = "Imprest: Pre-Approve Imprest Request";

    public function isMultiLevelApprovalsEnabled()
    {
        return (SettingsManager::getInstance()->getSetting('Travel: Enable Multi Level Approvals') == '1');
    }

    public function getAdminAccess()
    {
        return array("get", "element", "save", "delete");
    }

    public function getManagerAccess()
    {
        return array("get", "element", "save", "delete");
    }

    public function getUserAccess()
    {
        return array("get");
    }

    public function getUserOnlyMeAccess()
    {
        return array("element", "save", "delete");
    }

    public function fieldsNeedToBeApproved()
    {
        return array(
            "travel_from",
            "travel_to",
            "travel_date",
            "return_date",
            "funding",
            "currency"
        );
    }

    public function getType()
    {
        return 'EmployeeTravelRecord';
    }

    public function allowIndirectMapping()
    {
        if (SettingsManager::getInstance()->getSetting('Travel: Allow Indirect Admins to Approve') == '1') {
            return true;
        }
        return false;
    }

    
    public function getActiveRequests()
    { 
        $employee = new EmployeeTravelRecord();
        $list = $employee->Find("status = ?", array('Approved'));
        return $list;
    }

    

    public function apitraveldata($travel_employee_id){

    LogManager::getInstance()->info("=====TRAVEL ID ====>Gets here<======" );

    LogManager::getInstance()->info("=====TRAVEL ID ====>". $travel_employee_id ."<======" );
    
      // echo "gets here"; die();
    
        $mysqli = mysqli_connect("localhost", "root", "", "hrmdata");
        if (mysqli_connect_errno($mysqli)) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }
        
        $sql = "SELECT employeetravelrecords.*, currencytypes.id, currencytypes.imprest_gl, currencytypes.imprest_contra  FROM employeetravelrecords, currencytypes where currencytypes.id=employeetravelrecords.currency AND employeetravelrecords.id = '$travel_employee_id' ";
    
        // LogManager::getInstance()->info($sql);
        
    
        $res = mysqli_query($mysqli, $sql);
    
        // $res = mysqli_query($mysqli, "SELECT * FROM employeeexpenses where id = '$id' ");
        
        $row = mysqli_fetch_assoc($res);
        // echo $row['_msg'];
    
                        // $id = $row['id'];
                        $employee =  $row['employee'];
                        $employee_account = $row['emp_acc_no'];
                        $beneficiary_acc = $row['beneficiary_acc'];
                        $transaction_ref = $row['ref_no'];
                        $narration = $row['details'];
                        $amount = $row['funding'];
                        $local_equivalence = $row['local_eqv']; 
                        $imprest_gl = $row['imprest_gl']; 
                        $imprest_contra = $row['imprest_contra'];  
                        $documentRef = substr(base_convert(uniqid(sha1(mt_rand())), 16, 36), 0, 2) . time();

    
                        // echo $cust_account; die();
                        
         LogManager::getInstance()->info($employee ." ". $employee_account ." ". $beneficiary_acc ." ".$transaction_ref ." ". $narration ." ". $amount ." ". $local_equivalence." ". $imprest_gl." ". $imprest_contra);
    
    // LogManager::getInstance()->info("==USER==->".$emp ."<-=====");
        //  LogManager::getInstance()->info("===ID=>".$id."<==>".$id."<===Amount===");
        $sql_ = "UPDATE `employeetravelrecords` SET `documentRef` = '$documentRef' WHERE `employeetravelrecords`.`id` = '$travel_employee_id' ";

        $result_ = mysqli_query($mysqli, $sql_);
    
             
    $curl = curl_init();
    // http://10.93.121.144:9092/core/api/v1.0/account/:accountId/transfer
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => "http://10.93.121.144:9092/core/api/v1.0/account/$imprest_gl/transfer",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "PUT",
      CURLOPT_POSTFIELDS => "destinationAccountId=$imprest_contra&amount=$local_equivalence&documentRef=$transaction_ref&narration=$narration&postBy=UNIONADMIN&appBy=UG&customerTel=233206242008&transBy=USG&appBy=USG",
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/x-www-form-urlencoded",
        "x-api-key: 20171411891",
        "x-api-secret: 141116517P"
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    // echo $response;
    LogManager::getInstance()->info("=====FIRST TRANSACTION====>.$response.<======" );
    
        return new IceResponse(IceResponse::SUCCESS, $response);
         


    // $curl = curl_init();
    
    // curl_setopt_array($curl, array(
    //   CURLOPT_URL => "http://192.168.1.225:8680/core/api/v1.0/account/$imprest_contra/transfer",
    //   CURLOPT_RETURNTRANSFER => true,
    //   CURLOPT_ENCODING => "",
    //   CURLOPT_MAXREDIRS => 10,
    //   CURLOPT_TIMEOUT => 0,
    //   CURLOPT_FOLLOWLOCATION => true,
    //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //   CURLOPT_CUSTOMREQUEST => "PUT",
    //   CURLOPT_POSTFIELDS => "destinationAccountId=$beneficiary_acc&amount=$local_equivalence&documentRef=$transaction_ref&narration=$narration&postBy=UNIONADMIN&appBy=UG&customerTel=233206242008&transBy=USG&appBy=USG",
    //   CURLOPT_HTTPHEADER => array(
    //     "Content-Type: application/x-www-form-urlencoded",
    //     "x-api-key: 20171411891",
    //     "x-api-secret: 141116517P"
    //   ),
    // ));
    
    // $response = curl_exec($curl);
    
    // curl_close($curl);
    // // echo $response;
    // LogManager::getInstance()->info("=====SECOND TRANSACTION====>.$response.<======" );


        return new IceResponse(IceResponse::SUCCESS, $response);
    
    
               }
    




}
