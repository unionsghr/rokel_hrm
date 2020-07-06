<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 2:35 PM
 */

namespace Leaves\Common\Model;

use Model\BaseModel;

class EmployeeLeaveDay extends BaseModel
{
    public $table = 'EmployeeLeaveDays';
    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }

    public function getManagerAccess()
    {
        return array("get","element","save","delete");
    }

    public function getUserAccess()
    {
        return array("get");
    }

    public function getUserOnlyMeAccess()
    {
        return array("element","delete");
    }
}
