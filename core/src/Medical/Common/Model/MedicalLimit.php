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

class MedicalLimit extends BaseModel
{
    public $table = 'MedicalLimit';

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

   /* public function validateSave($obj)
    {
        $leavePeriod = new LeavePeriod();
        $leavePeriods = $leavePeriod->Find("1=1");

        if (strtotime($obj->date_end) <= strtotime($obj->date_start)) {
            return new IceResponse(IceResponse::ERROR, "Start date should be less than end date");
        }

        foreach ($leavePeriods as $lp) {
            if (!empty($obj->id) && $obj->id == $lp->id) {
                continue;
            }

            if (LeaveUtil::isCountryBasedLeavePeriodsEnabled() && $obj->country !== $lp->country) {
                continue;
            }

            if (strtotime($lp->date_end) >= strtotime($obj->date_end)
                && strtotime($lp->date_start) <= strtotime($obj->date_end)) {
                //-1---0---1---0 || ---0--1---1---0
                return new IceResponse(
                    IceResponse::ERROR,
                    "Leave period is overlapping with an existing one"
                );
            } elseif (strtotime($lp->date_end) >= strtotime($obj->date_start)
                && strtotime($lp->date_start) <= strtotime($obj->date_start)) {
                //---0---1---0---1 || ---0--1---1---0
                return new IceResponse(
                    IceResponse::ERROR,
                    "Leave period is overlapping with an existing one"
                );
            } elseif (strtotime($lp->date_end) <= strtotime($obj->date_end)
                && strtotime($lp->date_start) >= strtotime($obj->date_start)) {
                //--1--0---0--1--
                return new IceResponse(
                    IceResponse::ERROR,
                    "Leave period is overlapping with an existing one"
                );
            }
        }
        return new IceResponse(IceResponse::SUCCESS, "");
    }*/
}
