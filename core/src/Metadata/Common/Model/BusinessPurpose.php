<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 3:06 PM
 */

namespace Metadata\Common\Model;

use Model\BaseModel;
use Utils\LogManager;

class BusinessPurpose extends BaseModel
{
    public $table = 'BusinessPurpose';

    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }

    public function getUserAccess()
    {
        return array();
    }

    public function getAnonymousAccess()
    {
        return array("get","element");
    }
}
