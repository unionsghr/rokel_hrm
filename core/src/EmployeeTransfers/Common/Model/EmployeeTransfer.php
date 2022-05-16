<?php

/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/20/17
 * Time: 7:44 AM
 */

namespace EmployeeTransfers\Common\Model;

use Candidates\Common\Model\Application;
use Classes\IceResponse;
use Model\BaseModel;
use Utils\SessionUtils;

/**
 * Class EmployeeTransfer
 * @package EmployeeTransfers\Common\Model
 *
 * @property $id;
 * @property $employee;
 */

class EmployeeTransfer extends BaseModel
{
    public $table = 'Employees';

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
        return array("get", "element");
    }
}
