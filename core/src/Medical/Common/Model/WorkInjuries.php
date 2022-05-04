<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/20/17
 * Time: 7:44 AM
 */
use Classes\IceResponse;
use Leaves\Admin\Api\LeaveUtil;
namespace Medical\Common\Model;

use Model\BaseModel;

class WorkInjuries extends BaseModel
{
    public $table = 'WorkInjuries';

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
        return array("get", "element");
    }

    
}
