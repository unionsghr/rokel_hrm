<?php
namespace Audit\Admin\Api;

use Classes\SubActionManager;
use Model\Audit;
use Utils\LogManager;

class AuditActionManager extends SubActionManager
{

    public function addAudit($type, $data)
    {

        $audit = new Audit();
        $audit->user = $this->user->id;
        $audit->ip = $_SERVER['REMOTE_ADDR'];
        $audit->time = date("Y-m-d H:i:s");
        $audit->time = gmdate('Y-m-d H:i:s', strtotime($audit->time));
        $audit->type = $type;
        $audit->details = $data;

        $currentEmpId = $this->getCurrentProfileId();
        LogManager::getInstance()->info("=========Payroll=========currentEmpId=>".$currentEmpId);

        $currentEmpId = $this->getCurrentProfileId();
        if (!empty($currentEmpId)) {
            $employee = $this->baseService->getElement('Employee', $this->getCurrentProfileId(), null, true);
            $department = $this->baseService->getElement('CompanyStructure', $this->getCurrentProfileId(), null, true);
            $audit->full_name = $employee->first_name." ".$employee->middle_name." ".$employee->last_name." [EmpId = ".$employee->employee_id."]";
            // $audit->employee = $employee->first_name." ".$employee->middle_name." ".$employee->last_name;

            $audit->employee = $employee->first_name; 

            $audit->department = $department->title;
            // LogManager::getInstance()->info("Audit Employee=>".$employee);
        }

        $ok = $audit->Save();
        if (!$ok) {
            LogManager::getInstance()->info("Error adding audit:".$audit->ErrorMsg());
        }
    }
}
