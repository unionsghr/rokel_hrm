<?php
namespace Company\Common\Model;

use Model\BaseModel;

class Vw_outlets extends BaseModel
{
    public $table = 'vw_outlets';

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