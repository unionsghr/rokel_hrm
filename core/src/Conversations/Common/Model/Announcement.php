<?php
namespace Conversations\Common\Model;

use Model\BaseModel;

class Announcement extends BaseModel
{
    public $table = 'Conversations';

    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }

    public function getManagerAccess()
    {
        return array("get","element","save");
    }

    public function getUserAccess()
    {
        return array("get","element");
    }

    public function getUserOnlyMeAccess()
    {
        return array("get","element","save","delete");
    }
}
