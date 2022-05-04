<?php
namespace Company\Common\Model;

use Model\BaseModel;

class Vw_departments extends BaseModel
{
    public $table = 'vw_departments';

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
        return array("get","element");
    }
}