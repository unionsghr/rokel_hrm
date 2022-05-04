<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 12:10 PM
 */

namespace Expenses\Common\Model;

use Model\BaseModel;
 
class Vw_EmployeeImprest extends BaseModel
{
    public $table = 'vw_employeeimprest';

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
        return array("get","element");
    }
}
