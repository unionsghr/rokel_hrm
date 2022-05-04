<?php
namespace Reports\Admin\Reports;

use Classes\BaseService;
use Reports\Admin\Api\ClassBasedReportBuilder;
use Reports\Admin\Api\ReportBuilderInterface;

class EmployeeAttendanceReport extends ClassBasedReportBuilder implements ReportBuilderInterface
{

    public function getData($report, $request)
    {
        $filters = [];


        if (!empty($request['type']) && $request['type'] !== "NULL") {
            $filters['type'] = $request['type'];
        }

        if (!empty($request['employee']) && $request['employee'] !== "NULL") {
            $filters['employee'] = $request['employee'];
        }


        if (!empty($request['department']) && $request['department'] !== "NULL") {
            $filters['department'] = $request['department'];
        }

        if (empty($request['in_time']) || $request['in_time'] == "NULL") {
            $request['in_time'] = date("Y-m-d 00:00:00");
        }
        
        if (empty($request['out_time']) || $request['out_time'] == "NULL") {
            $request['out_time'] = date("Y-m-d 23:59:59");
        }

        
        $mapping = [
            "employee" => ["Employee","id","first_name+middle_name+last_name"],
            "department" => ["CompanyStructure","id","title"],
            // "code" => ["Employee","id","first_name+middle_name+last_name"],
        ]; 


    
        $reportColumns = [
            // ['label' => 'ID', 'column' => 'code'],
            ['label' => 'Employee', 'column' => 'employee'],
            ['label' => 'Department', 'column' => 'department'], 
            ['label' => 'Time - IN', 'column' => 'in_time'],
            ['label' => 'Time - OUT', 'column' => 'out_time'],
        ];

        $customFieldsList = BaseService::getInstance()->getCustomFields('attendance');

        foreach ($customFieldsList as $customField) {
            $reportColumns[] = [
                'label' => $customField->field_label,
                'column' => $customField->name,
            ];
        }

        $entries = BaseService::getInstance()->get('Attendance', null, $filters);
        $data = [];
        foreach ($entries as $item) {
            $item =  BaseService::getInstance()->enrichObjectMappings($mapping, $item);
            $item =  BaseService::getInstance()->enrichObjectCustomFields('Attendance', $item);
            $data[] = $item;
        }

        $mappedColumns = array_keys($mapping);


        $reportData = [];
        $reportData[] = array_column($reportColumns, 'label');

        foreach ($data as $item) {
            $row = [];
            foreach ($reportColumns as $column) {
                if (in_array($column['column'], $mappedColumns)) {
                    $row[] = $item->{$column['column'].'_Name'};
                } else {
                    $row[] = $item->{$column['column']};
                }
            }
            $reportData[] = $row;
        }

        return $reportData;
    }
}
