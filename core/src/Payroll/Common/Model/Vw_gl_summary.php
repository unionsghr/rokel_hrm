<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 4:16 PM
 */

namespace Payroll\Common\Model;

use Model\BaseModel;

class Vw_gl_summary extends BaseModel
{
    public $table = 'Vw_gl_summary';

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
        return array();
    }
} 
