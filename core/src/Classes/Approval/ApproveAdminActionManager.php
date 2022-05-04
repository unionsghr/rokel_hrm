<?php

namespace Classes\Approval;
use Classes\BaseService;
use Classes\IceConstants;
use Classes\IceResponse;
use Classes\StatusChangeLogManager;
use Model\BaseModel;
use Utils\LogManager;
use Expenses\Common\Model\EmployeeExpense;
use Travel\Common\Model\EmployeeTravelRecord;

abstract class ApproveAdminActionManager extends ApproveCommonActionManager
{

    // LogManager::getInstance()->info("|All multi level approvals completed, now we can approve|");

    abstract public function getModelClass();
    abstract public function getItemName();
    abstract public function getModuleName();
    abstract public function getModuleTabUrl();
    abstract public function getModuleSubordinateTabUrl();
    abstract public function getModuleApprovalTabUrl();

    public function changeStatus($req)
    {

        $test = $req->status;
        $amount = $req->amount;
        $employee_id = $req->employee_Id;

        $travel_employee_id = $req->emp_Id;

        //     $user = $this->baseService->getCurrentUser();           
        //     $noti= $user->username;
        // LogManager::getInstance()->info("====> ".$noti." <====Testing employee trainig session");


        // LogManager::getInstance()->info( "------ TRAVEL APPROVAL ----------");


        $class = $this->getModelClass();
        $itemName = $this->getItemName();
        /* @var BaseModel $obj */
        $nsClass = BaseService::getInstance()->getFullQualifiedModelClassName($class);
        $obj = new $nsClass();
        $obj->Load("id = ?", array($req->id));

        if ($obj->id != $req->id) {
            return new IceResponse(IceResponse::ERROR, "$itemName not found");
        }

        
        //Check if this needs to be multi-approved
        $apStatus = 0;

        // $status = $req->employee;
        // $employee = $req->employee;

        // LogManager::getInstance()->info("===STATUS===>".$status."<==>".$employee."<==EMPLOYEE===");

        if ($req->status == "Approved") {
            $apStatus = 1;
        }

         

        if ($req->status == "Approved" || $req->status == "Rejected") {
            $approvalResp = ApprovalStatus::getInstance()->updateApprovalStatus(
                $class,
                $obj->id,
                BaseService::getInstance()->getCurrentProfileId(),
                $apStatus
            );

            if ($approvalResp->getStatus() == IceResponse::SUCCESS) {
                $objResp = $approvalResp->getObject();
                $currentAp  = $objResp[0];
                $nextAp     = $objResp[1];
                $sendApprovalEmailto = null;
                if (empty($currentAp) && empty($nextAp)) {
                    //No multi level approvals
                    LogManager::getInstance()->debug($obj->id."|No multi level approvals|");
                    if ($req->status == "Approved") {
                        $req->status = "Approved";

            LogManager::getInstance()->info( "----- Testing Before API -----");

                        EmployeeExpense::apiexpensedata($employee_id);
                        EmployeeTravelRecord::apitraveldata($travel_employee_id);

            LogManager::getInstance()->info("==== After API No MultiApprove ====");
 
                    }
                    
                } elseif (empty($currentAp) && !empty($nextAp)) {
                    //Approval process is defined, but this person is a supervisor
                    LogManager::getInstance()->debug(
                        $obj->id."|Approval process is defined, but this person is a supervisor|"
                    );
                    $sendApprovalEmailto = $nextAp->approver;
                    if ($req->status == "Approved") {

                    LogManager::getInstance()->info("--- PROCESSING ---");
      
                        // EmployeeExpense::apiexpensedata();

                        $req->status = "Approved";
                    }
                } elseif (!empty($currentAp) && empty($nextAp)) {
                    //All multi level approvals completed, now we can approve
                    LogManager::getInstance()->debug(
                        $obj->id."|All multi level approvals completed, now we can approve|"
                    );
                    if ($req->status == "Approved") {

                    LogManager::getInstance()->info("================ All multiApprove EMPLOYEE EXPENSE API ===============-");
                        $req->status = "Approved";
                        EmployeeExpense::apiexpensedata($employee_id);
                        EmployeeTravelRecord::apitraveldata($travel_employee_id);
                    }
                } else {
                    //Current employee is an approver and we have another approval level left
                    LogManager::getInstance()->debug(
                        $obj->id."|Current employee is an approver and we have another approval level left|"
                    );
                    $sendApprovalEmailto = $nextAp->approver;
                    if ($req->status == "Approved") {

                    LogManager::getInstance()->info("===== PROCESSING 2 ======");
      
                        $req->status = "Processing";
                        // EmployeeExpense::apiexpensedata();
                    }
                }
            } else {
                return $approvalResp;
            }
        }

        $oldStatus = $obj->status;
        $obj->status = $req->status;

        if ($oldStatus == $req->status && $req->status != "Processing") {
            return new IceResponse(IceResponse::SUCCESS, "");
        }

        $ok = $obj->Save();

        if (!$ok) { 
            LogManager::getInstance()->info($obj->ErrorMsg());
            return new IceResponse(
                IceResponse::ERROR,
                "Error occurred while saving $itemName information. Please contact admin"
            );
        }

        StatusChangeLogManager::getInstance()->addLog(
            $class,
            $obj->id,
            BaseService::getInstance()->getCurrentUser()->id,
            $oldStatus,
            $req->status,
            ""
        ); 

        $this->baseService->audit(
            IceConstants::AUDIT_ACTION,
            "$itemName status changed from:".$oldStatus." to:".$obj->status." id:".$obj->id
        );

        $currentEmpId = $this->getCurrentProfileId();

        LogManager::getInstance()->info("===>".$currentEmpId."<==currentEmpId==");



        if (!empty($currentEmpId)) {
            $employee = $this->baseService->getElement('Employee', $currentEmpId, null, true);

            $notificationMsg
                = "Your $itemName has been $obj->status by ".$employee->first_name." ".$employee->middle_name." ".$employee->last_name;
                
                LogManager::getInstance()->info("===>".$notificationMsg."<==testttt==");

            if (!empty($req->reason)) {
                $notificationMsg.=" (Note:".$req->reason.")";
            }

            $this->baseService->notificationManager->addNotification(
                $obj->employee,
                $notificationMsg,
                '{"type":"url","url":"'.$this->getModuleTabUrl().'"}',
                $this->getModuleName(),
                null,
                false,
                true
            );
        }

        if (!empty($sendApprovalEmailto)) {
            $employee = $this->baseService->getElement(
                'Employee',
                BaseService::getInstance()->getCurrentProfileId(),
                null,
                true
            );

            LogManager::getInstance()->info("===EMPLOYEE===>".$employee."====EMPLOYEE===");

            $notificationMsg
                = "You have been assigned ".$itemName." for approval by ".
                    $employee->first_name." ".$employee->middle_name." ".$employee->last_name;

        LogManager::getInstance()->info("===>".$notificationMsg."<==2==");

            $this->baseService->notificationManager->addNotification(
                $sendApprovalEmailto,
                $notificationMsg,
                '{"type":"url","url":"'.$this->getModuleApprovalTabUrl().'"}',
                $this->getModuleName(),
                null,
                false,
                true
            );
        }

        return new IceResponse(IceResponse::SUCCESS, "");
    }
}
