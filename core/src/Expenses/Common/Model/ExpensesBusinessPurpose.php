<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 12:10 PM
 */

namespace Expenses\Common\Model;

use Model\BaseModel;
 
class ExpensesBusinessPurpose extends BaseModel
{
    public $table = 'ExpensesBusinessPurpose';

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
