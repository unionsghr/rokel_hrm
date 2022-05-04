<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 1:39 PM
 */

namespace Leaves\Admin\Api;

use Classes\IceConstants;
use Classes\IceResponse;
use Classes\SubActionManager;
use Employees\Common\Model\Employee;
use Leaves\Common\Model\EmployeeLeave;
use Leaves\Common\Model\EmployeeLeaveDay;
use Leaves\Common\Model\EmployeeLeaveLog;
use Leaves\Common\Model\LeaveGroupEmployee;
use Leaves\Common\Model\LeavePeriod;
use Leaves\Common\Model\LeaveRule;
use Leaves\Common\Model\LeaveStartingBalance;
use Leaves\Common\Model\LeaveType;
use Users\Common\Model\User;
use Utils\LogManager;

class LeavesActionManager extends SubActionManager
{
    const FULLDAY = 1;
    const HALFDAY = 0;
    const NOTWORKINGDAY = 2;

    /* @var \Leaves\User\Api\LeavesActionManager $userLeaveActionManager */
    protected $userLeaveActionManager = null;

    private function isLeaveNotificationsEnabled($leaveTypeId)
    {
       
        $leaveType = new LeaveType();
        $leaveType->Load("id = ?", array($leaveTypeId));
        if (!empty($leaveType->id) && $leaveType->send_notification_emails == "No") {
            return false;
        }

        return true;
    }

    /**
     * @return \Leaves\User\Api\LeavesActionManager
     */
    protected function getUserLeaveActionManager()
    {
        if ($this->userLeaveActionManager === null) {
            $this->userLeaveActionManager = new \Leaves\User\Api\LeavesActionManager();
            $this->userLeaveActionManager->setBaseService($this->baseService);
            $this->userLeaveActionManager->setUser($this->user);
        }

        return $this->userLeaveActionManager;
    }

    public function getLeaveDaysReadonly($req)
    {
        
        $leaveId = $req->leave_id;
        $leaveLogs = array();

        $employeeLeave = new EmployeeLeave();
        $employeeLeave->Load("id = ?", array($leaveId));

        $employee = $this->baseService->getElement('Employee', $employeeLeave->employee, null, true);

        $currentLeavePeriodResp = LeaveUtil::getCurrentLeavePeriod(
            $employeeLeave->date_start,
            $employeeLeave->date_end
        );
        if ($currentLeavePeriodResp->getStatus() != IceResponse::SUCCESS) {
            return new IceResponse(IceResponse::ERROR, $currentLeavePeriodResp->getData());
        } else {
            $currentLeavePeriod = $currentLeavePeriodResp->getData();
        }

        $leaveMatrix = $this->getAvailableLeaveMatrixForEmployeeLeaveType(
            $employee,
            $currentLeavePeriod,
            $employeeLeave->leave_type
        );

        $leaves = array();
        $leaves['totalLeaves'] = floatval($leaveMatrix[0]);
        $leaves['pendingLeaves'] = floatval($leaveMatrix[1]);
        $leaves['approvedLeaves'] = floatval($leaveMatrix[2]);
        $leaves['rejectedLeaves'] = floatval($leaveMatrix[3]);
        $leaves['cancelRequestedLeaves'] = floatval($leaveMatrix[4]);
        $leaves['cancelledLeaves'] = floatval($leaveMatrix[5]);
        $leaves['availableLeaves'] = $leaves['totalLeaves'] - $leaves['pendingLeaves']
            -  $leaves['approvedLeaves'] - $leaves['cancelRequestedLeaves'];
        $leaves['attachment'] = $employeeLeave->attachment;

        $employeeLeaveDay = new EmployeeLeaveDay();
        $days = $employeeLeaveDay->Find("employee_leave = ?", array($leaveId));

        $employeeLeaveLog = new EmployeeLeaveLog();
        $logsTemp = $employeeLeaveLog->Find("employee_leave = ? order by created", array($leaveId));
        foreach ($logsTemp as $empLeaveLog) {
            $t = array();
            $t['time'] = $empLeaveLog->created;
            $t['status_from'] = $empLeaveLog->status_from;
            $t['status_to'] = $empLeaveLog->status_to;
            $t['time'] = $empLeaveLog->created;
            $userName = null;
            if (!empty($empLeaveLog->user_id)) {
                $lgUser = new User();
                $lgUser->Load("id = ?", array($empLeaveLog->user_id));
                // LogManager::getInstance()->info("=====lgadmin====>".$lgUser);
                if ($lgUser->id == $empLeaveLog->user_id) {
                    if (!empty($lgUser->employee)) {
                        $lgEmployee = new Employee();
                        $lgEmployee->Load("id = ?", array($lgUser->employee));
                        $userName = $lgEmployee->first_name." ".$lgEmployee->middle_name." ".$lgEmployee->last_name;
                    } else {
                        $userName = $lgUser->userName;
                    }
                }
            }

            if (!empty($userName)) {
                $t['note'] = $empLeaveLog->data." (by: ".$userName.")";
            } else {
                $t['note'] = $empLeaveLog->data;
            }

            $leaveLogs[] = $t;
        }

        return new IceResponse(IceResponse::SUCCESS, array($days,$leaves,$leaveId,$employeeLeave,$leaveLogs));
    }

    private function getAvailableLeaveMatrixForEmployee($employee, $currentLeavePeriod)
    {

        //Iterate all leave types and create leave matrix
        /**
         * [[Leave Type],[Total Available],[Pending],[Approved],[Rejected]]
         */

        $leaveGroupIds = LeaveUtil::getEmployeeLeaveGroups($employee->id);

        $leaveType = new LeaveType();
        if (empty($leaveGroupId)) {
            $leaveTypes = $leaveType->Find("leave_group IS NULL", array());
        } else {
            $leaveTypes = $leaveType->Find(
                "leave_group IS NULL or leave_group in (".implode(',', $leaveGroupIds).")",
                array()
            );
        }

        foreach ($leaveTypes as $leaveType) {
            $employeeLeaveQuota = new \stdClass();

            $rule = LeaveUtil::getLeaveRule($employee, $leaveType->id, $currentLeavePeriod);
            $employeeLeaveQuota->avalilable = floatval($rule->default_per_year) + floatval($rule->pto);
            $pending = LeaveUtil::countLeaveAmounts(
                LeaveUtil::getEmployeeLeaves($employee->id, $currentLeavePeriod->id, $leaveType->id, 'Pending')
            );
            $approved = LeaveUtil::countLeaveAmounts(
                LeaveUtil::getEmployeeLeaves($employee->id, $currentLeavePeriod->id, $leaveType->id, 'Approved')
            );
            $rejected = LeaveUtil::countLeaveAmounts(
                LeaveUtil::getEmployeeLeaves($employee->id, $currentLeavePeriod->id, $leaveType->id, 'Rejected')
            );

            $leaveCounts[$leaveType->name] = array(0,$pending,$approved,$rejected);
        }

        return $leaveCounts;
    }

    private function getAvailableLeaveMatrixForEmployeeLeaveType($employee, $currentLeavePeriod, $leaveTypeId)
    {

        /**
         * [Total Available],[Pending],[Approved],[Rejected],[Cancellation Requested],[Cancelled]
         */

        $rule = LeaveUtil::getLeaveRule($employee, $leaveTypeId, $currentLeavePeriod);
        $avalilableLeaves = $this->getAvailableLeaveCount($employee, $rule, $currentLeavePeriod, $leaveTypeId);
        $avalilable = $avalilableLeaves[0];
        $pending = LeaveUtil::countLeaveAmounts(
            LeaveUtil::getEmployeeLeaves($employee->id, $currentLeavePeriod->id, $leaveTypeId, 'Pending')
        );
        $approved = LeaveUtil::countLeaveAmounts(
            LeaveUtil::getEmployeeLeaves($employee->id, $currentLeavePeriod->id, $leaveTypeId, 'Approved')
        );
        $rejected = LeaveUtil::countLeaveAmounts(
            LeaveUtil::getEmployeeLeaves($employee->id, $currentLeavePeriod->id, $leaveTypeId, 'Rejected')
        );
        $cancelRequested = LeaveUtil::countLeaveAmounts(
            LeaveUtil::getEmployeeLeaves($employee->id, $currentLeavePeriod->id, $leaveTypeId, 'Cancellation Requested')
        );
        $cancelled = LeaveUtil::countLeaveAmounts(
            LeaveUtil::getEmployeeLeaves($employee->id, $currentLeavePeriod->id, $leaveTypeId, 'Cancelled')
        );

        return array($avalilable,$pending,$approved,$rejected,$cancelRequested,$cancelled);
    }

    /*
     * Find available leave counts considering Leaves Accrued and Carried Forward
    */
    private function getAvailableLeaveCount($employee, $rule, $currentLeavePeriod, $leaveTypeId)
    {
        return $this->getUserLeaveActionManager()->getAvailableLeaveCount(
            $employee,
            $rule,
            $currentLeavePeriod,
            $leaveTypeId
        );
    }

    public function getSubEmployeeLeaves($req)
    {

        $mappingStr = $req->sm;
        $map = json_decode($mappingStr);
        $employeeLeave = new EmployeeLeave();
        $list = $employeeLeave->Find("1=1");
        if (!$list) {
            LogManager::getInstance()->info($employeeLeave->ErrorMsg());
        }
        if (!empty($mappingStr)) {
            $list = $this->baseService->populateMapping($list, $map);
        }

        return new IceResponse(IceResponse::SUCCESS, $list);
    }

    public function changeLeaveStatus($req)
    {

        //$employee = $this->baseService->getElement('Employee',$this->getCurrentProfileId());

        $employeeLeave = new EmployeeLeave();
        $employeeLeave->Load("id = ?", array($req->id));
        if ($employeeLeave->id != $req->id) {
            return new IceResponse(IceResponse::ERROR, "Leave not found");
        }

        if ($this->user->user_level != 'Admin') {
            return new IceResponse(IceResponse::ERROR, "Only an admin can do this");
        }

        $oldLeaveStatus = $employeeLeave->status;
        $employeeLeave->status = $req->status;
        $ok = $employeeLeave->Save();
        if (!$ok) {
            LogManager::getInstance()->info($employeeLeave->ErrorMsg());
            return new IceResponse(
                IceResponse::ERROR,
                "Error occured while saving leave information. Please contact admin"
            );
        }

        $employeeLeaveLog = new EmployeeLeaveLog();
        $employeeLeaveLog->employee_leave = $employeeLeave->id;
        $employeeLeaveLog->user_id = $this->baseService->getCurrentUser()->id;
        $employeeLeaveLog->status_from = $oldLeaveStatus;
        $employeeLeaveLog->status_to = $employeeLeave->status;
        $employeeLeaveLog->created = date("Y-m-d H:i:s");
        $employeeLeaveLog->data = isset($req->reason)?$req->reason:"";
        $ok = $employeeLeaveLog->Save();
        if (!$ok) {
            LogManager::getInstance()->info($employeeLeaveLog->ErrorMsg());
        }

        $employee = $this->getEmployeeById($employeeLeave->employee);

        if ($oldLeaveStatus != $employeeLeave->status
            && $this->isLeaveNotificationsEnabled($employeeLeave->leave_type) == true
        ) {
            $this->sendLeaveStatusChangedEmail($employee, $employeeLeave);
        }

        $this->baseService->audit(
            IceConstants::AUDIT_ACTION,
            "Leave status changed \ from:".$oldLeaveStatus."\ to:".$employeeLeave->status." \ id:".$employeeLeave->id
        );

        $currentEmpId = $this->getCurrentProfileId();

        if (!empty($currentEmpId)) {
            $employee = $this->baseService->getElement('Employee', $currentEmpId);

            if ($employeeLeave->status != "Pending") {
                $notificationMsg
                    = "Your leave status has been changed to $employeeLeave->status by ".$employee->first_name." ".$employee->middle_name." ".$employee->last_name;
                if (!empty($req->reason)) {
                    $notificationMsg.=" (Note:".$req->reason.")";
                }
            }

            $this->baseService->notificationManager->addNotification(
                $employeeLeave->employee,
                $notificationMsg,
                '{"type":"url","url":"g=modules&n=leaves&m=module_Leaves#tabEmployeeLeaveApproved"}',
                IceConstants::NOTIFICATION_LEAVE
            );
        }

        return new IceResponse(IceResponse::SUCCESS, "");
    }

    public function sendLeaveStatusChangedEmail($employee, $leave)
    {

        $emp = $this->getEmployeeById($leave->employee);

        $params = array();
        $params['name'] = $emp->first_name." ".$emp->middle_name." ".$emp->middle_name." ".$emp->last_name;
        $params['startdate'] = $leave->date_start;
        $params['enddate'] = $leave->date_end;
        $params['status'] = $leave->status;

        $user = $this->getUserFromProfileId($employee->id);

        if (!empty($user)) {
            $email = file_get_contents(APP_BASE_PATH."modules/leaves/emailTemplates/leaveStatusChanged.html");
            if (!empty($this->emailSender)) {
                $this->emailSender->sendEmail("Leave Application ".$leave->status, $user->email, $email, $params);
            }
        }
    }

    private function getEmployeeById($id)
    {
        $sup = new Employee();
        $sup->Load("id = ?", array($id));
        if ($sup->id != $id) {
            LogManager::getInstance()->info("Employee not found");
            return null;
        }

        return $sup;
    }
}
