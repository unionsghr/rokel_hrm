<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 11:11 PM
 */
  
namespace Salary\Common\Model;
 
use Model\BaseModel;

class Vw_Final_Salaries extends BaseModel
{
    public $table = 'vw_final_salaries';

    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }

    public function getManagerAccess()
    {
        return array();
    }

    public function getUserAccess()
    {
        return array();
    }

    public function getUserOnlyMeAccess()
    {
        return array("get", "element");
    }

    public function getUserOnlyMeSwitchedAccess()
    {
        return array();
    }
}
