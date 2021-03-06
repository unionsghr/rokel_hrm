<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 2:23 PM
 */

namespace Leaves\Common\Model;

use Model\BaseModel;

class LeaveStartingBalance extends BaseModel
{
    public $table = 'LeaveStartingBalance';
    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }

    public function getUserAccess()
    {
        return array();
    }
}
