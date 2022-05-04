<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 12:52 PM
 */

namespace Jobs\Common\Model;

use Model\BaseModel;

class Titles extends BaseModel
{
    public $table = 'Titles';

    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }
}
