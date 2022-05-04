<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/20/17
 * Time: 8:16 AM
 */

namespace Travel\User\Api;

use Classes\Approval\ApproveModuleActionManager;

class TravelActionManager extends ApproveModuleActionManager
{

    public function getModelClass()
    {
        return "EmployeeTravelRecord";
    }

    public function getItemName()
    {
        return "Imprest Request";
    }

    public function getModuleName()
    {
        return "Imprest Management";
    }

    public function getModuleTabUrl()
    {
        return "g=modules&n=travel&m=module_Travel_Management#tabSubordinateEmployeeTravelRecord";
    }

    public function getLogs($req)
    {
        return parent::getLogs($req);
    }

    public function cancel($req)
    {
        return parent::cancel($req);
    }
}
