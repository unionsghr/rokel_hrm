<?php
namespace LeaveCharts\Admin\Api;

use Classes\FileService;
use Classes\IceResponse;
use Classes\SubActionManager;
use Employees\Common\Model\Employee;
use Leaves\Admin\Api\LeaveUtil;
use Leaves\Common\Model\EmployeeLeave;

class LeaveChartsActionManager extends SubActionManager
{

    public function getUpcomingApprovedLeaves($req)
    {
        $resp = LeaveUtil::getCurrentLeavePeriod(date('Y-m-d'), date('Y-m-d'));

        if ($resp->getStatus() !== IceResponse::SUCCESS) {
            return new IceResponse(IceResponse::ERROR, "Current leave period is not defined");
        }

        $leavePeriod = $resp->getObject();

        $employeeLeave = new EmployeeLeave();

        $list = $employeeLeave->Find(
            "status = 'Approved' and ((date_start >= ? and date_start <= ? )"
            ." or (date_end >= ? and date_end <= ?))",
            array($leavePeriod->date_start,$leavePeriod->date_end,$leavePeriod->date_start,$leavePeriod->date_end)
        );

        $timeline = [];
        foreach ($list as $employeeLeave) {
            $timeline[] = $this->convertToChartTimeLine($employeeLeave);
        }


        return new IceResponse(IceResponse::SUCCESS, $timeline);
    }

    protected function convertToChartTimeLine($employeeLeave)
    {

        $employee = new Employee();
        $employee->Load("id = ?", [$employeeLeave->employee]);

        $employee = FileService::getInstance()->updateSmallProfileImage($employee);

        if ($employeeLeave->date_start === $employeeLeave->date_end) {
            $period = date('M j', strtotime($employeeLeave->date_start));
        } else {
            $period = date('M j', strtotime($employeeLeave->date_start))
                .' to '.date('M j', strtotime($employeeLeave->date_end));
        }

        return [
            'employee' => $employee->first_name . ' ' . $employee->middle_name . ' ' . $employee->last_name,
            'start' => $employeeLeave->date_start.'T00:00:00',
            'image' => $employee->image,
            'details' => $period,
        ];
    }
}
