<?php

/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 12:06 PM
 */

namespace EmployeeTransfers\Admin\Api;

use Classes\Approval\ApproveAdminActionManager;
use Classes\Approval\ApprovalStatus;
use Classes\Approval\ApproveCommonActionManager;
use Classes\Approval\ApproveModuleActionManager;
use Classes\IceResponse;
use Utils\LogManager;

class EmployeeTransferActionManager extends ApproveAdminActionManager
{

  public function getModelClass()
  {
    // LogManager::getInstance()->info("-========---- EXPENSE ACTION MANAGER MODEL CLASS-----=====");

    return "EmployeeTransfer";
  }

  public function getItemName()
  {
    return "EmployeeTransfers";
  }

  public function getModuleName()
  {
    return "Transfer Management";
  }

  public function getModuleTabUrl()
  {
    return "g=modules&n=employeetransfer&m=module_Employee";
  }

  public function getModuleSubordinateTabUrl()
  {
    return "g=modules&n=expenses&m=module_Employee#tabSubordinateEmployeeTransfers";
  }

  public function getModuleApprovalTabUrl()
  {
    return "g=modules&n=expenses&m=module_Finance#tabEmployeeExpenseApproval";
  }

  public function getLogs($req)
  {
    return parent::getLogs($req);
  }

  public function changeStatus($req)
  {
    return parent::changeStatus($req);
  }

 
}
