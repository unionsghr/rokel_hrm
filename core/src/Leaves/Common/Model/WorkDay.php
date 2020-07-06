<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 2:21 PM
 */

namespace Leaves\Common\Model;

use Model\BaseModel;

class WorkDay extends BaseModel
{
    public $table = 'WorkDays';
    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }
}
