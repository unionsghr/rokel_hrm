<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 2:34 PM
 */

namespace Leaves\Common\Model;

use Classes\BaseService;
use Classes\IceResponse;
use Classes\SettingsManager;
use Model\BaseModel;

class EmployeeLeave extends BaseModel
{
    public $table = 'EmployeeLeaves';
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
        return array("element", "delete");
    }

    public function executePreDeleteActions($obj)
    {
        $user = BaseService::getInstance()->getCurrentUser();
        if ($obj->status !== 'Pending' && $user->user_level !== 'Admin') {
            return new IceResponse(IceResponse::ERROR, 'You are not allowed to delete this leave');
        }
        return new IceResponse(IceResponse::SUCCESS, null);
    }

    public function allowIndirectMapping()
    {
        if (SettingsManager::getInstance()->getSetting("Leave: Allow Indirect Admins to Approve") == "1") {
            return true;
        }
        return false;
    }

    public function getDisplayName()
    {
        return "Leave Request";
    }

    public function apileaveapproval($employee_id)
    {

        $mysqli = mysqli_connect("localhost", "root", "", "hrmdata");
        if (mysqli_connect_errno($mysqli)) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        // $employee_id = '22';
        $res = mysqli_query($mysqli, "SELECT * FROM `employeeleaves` WHERE id = '$employee_id'");

        $row = mysqli_fetch_assoc($res);

        $destinationAccountId = $row['leave_gl'];
        $allowance_rate = $row['allowance_rate'];
        $amount = $row['amount'];
        $description = $row['leave_name'];
        $cust_account = $row['emp_acc_no'];
        $leave_allowance = $row['leave_allowance'];
//111121000000
        $documentRef = substr(base_convert(uniqid(sha1(mt_rand())), 16, 36), 0, 2) . time();

        $final_allowance = ($amount * $allowance_rate / 100);
// $final_allowance = ($amount);

        $sql_ = "UPDATE `employeeleaves` SET `documentRef` = '$documentRef', allowance_status = 'Paid'  WHERE `employeeleaves`.`id` = '$employee_id'";
        // $sql_ = "UPDATE `employeeleaves` SET `documentRef` = '$documentRef', 'allowance_status' = 'Paid' WHERE `employeeleaves`.`id` = '$employee_id' AND '$leave_allowance' = 'Yes' ";
        // UPDATE `employeeleaves` SET `documentRef` = '$documentRef', allowance_status = 'Paid'  WHERE `employeeleaves`.`id` = '$employee_id' 
        mysqli_query($mysqli, $sql_);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://192.168.1.225:8680/core/api/v1.0/account/' . $destinationAccountId . '/transfer',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS => 'destinationAccountId=' . $cust_account . '&amount=' . $final_allowance . '&documentRef=' . $documentRef . '&narration=' . $description . '&postBy=UNIONADMIN&appBy=UG&customerTel=233206242008&transBy=USG&appBy=USG&=',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
                'x-api-key: 20171411891',
                'x-api-secret: 141116517P',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

}
