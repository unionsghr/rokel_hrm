<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/20/17
 * Time: 7:40 AM
 */

namespace StaffDirectory\Common\Model;

use Classes\FileService;
use Employees\Common\Model\Employee;
use Model\BaseModel;

class StaffDirectory extends Employee
{
    // @codingStandardsIgnoreStart
    public function Find($whereOrderBy, $bindarr = false, $pkeysArr = false, $extra = array())
    {
        // @codingStandardsIgnoreEnd
        $res = parent::Find($whereOrderBy, $bindarr, $pkeysArr, $extra);
        $data = array();
        //$img = '<img src="_img_" class="img-circle" style="width:45px;height: 45px;" alt="User Image">';
        foreach ($res as $entry) {
            $emp = new BaseModel();
            $emp->id = $entry->id;
            $emp = FileService::getInstance()->updateProfileImage($emp);
            //$emp->image = str_replace("_img_",$emp->image,$img);
            $emp->first_name = $entry->first_name;
            $emp->middle_name = $entry->middle_name;
            $emp->last_name = $entry->last_name;
            $emp->job_title = $entry->job_title;
            $emp->department = $entry->department;
            $emp->work_phone = $entry->work_phone;
            $emp->work_email = $entry->work_email;
            $emp->joined_date = $entry->joined_date;
            $emp->gender = $entry->gender;
            $emp->_org = $entry;
            $data[] = $emp;
        }

        return $data;
    }

    // @codingStandardsIgnoreStart
    public function Insert()
    {
        return;
    }

    public function Delete()
    {
        return;
    }
    // @codingStandardsIgnoreEnd
}
