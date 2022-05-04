<?php
namespace Reports\Admin\Reports;

use Classes\BaseService;
use Reports\Admin\Api\ClassBasedReportBuilder;
use Reports\Admin\Api\ReportBuilderInterface;

class JobPositionsReport extends ClassBasedReportBuilder implements ReportBuilderInterface
{

    public function getData($report, $request)
    {
        // $filters = [];


        // if (!empty($request['type']) && $request['type'] !== "NULL") {
        //     $filters['type'] = $request['type'];
        // }

        // if (!empty($request['employee']) && $request['employee'] !== "NULL") {
        //     $filters['employee'] = $request['employee'];
        // }


        // if (!empty($request['department']) && $request['department'] !== "NULL") {
        //     $filters['department'] = $request['department'];
        // }

        
        $mapping = [
            "employee" => ["Employee","id","first_name+middle_name+last_name"],
            "department" => ["CompanyStructure","id","title"],
            "country" => ["Country","id","name"],
            "company" => ["CompanyStructure","id","title"],
            "postedBy" => ["Employee","id","first_name+middle_name+last_name"],
            
            // "code" => ["Employee","id","first_name+middle_name+last_name"],
        ]; 


    
        $reportColumns = [
            // ['label' => 'ID', 'column' => 'code'],
            ['label' => 'Title', 'column' => 'title'],
            ['label' => 'Reason', 'column' => 'positionReason'],
            ['label' => 'Short Description', 'column' => 'shortDescription'],
            ['label' => 'Detailed Description', 'column' => 'description'],
            ['label' => 'Requirements', 'column' => 'requirements'],
            ['label' => 'Benefits', 'column' => 'benefits'],
            ['label' => 'Country', 'column' => 'country'],
            ['label' => 'Location', 'column' => 'location'],
            ['label' => 'Company Name', 'column' => 'companyName'],
            ['label' => 'Company', 'column' => 'company'],
            ['label' => 'Department', 'column' => 'department'],
            ['label' => 'code', 'column' => 'code'],
            ['label' => 'Employment Type', 'column' => 'employementType'],
            ['label' => 'Hiring Manager', 'column' => 'hiringManager'],
            ['label' => 'Industry', 'column' => 'industry'],
            ['label' => 'Postal Code', 'column' => 'postalCode'],
            ['label' => 'Experience Level', 'column' => 'experienceLevel'],
            ['label' => 'Job Function', 'column' => 'jobFunction'],
            ['label' => 'Education Level', 'column' => 'educationLevel'],
            ['label' => 'Currency', 'column' => 'currency'],
            ['label' => 'Minimum Salary', 'column' => 'salaryMin'],
            ['label' => 'Maximum Salary', 'column' => 'salaryMax'],
            ['label' => 'Status', 'column' => 'status '],
            ['label' => 'Closing Date', 'column' => 'closingDate'],
            ['label' => 'Posted By', 'column' => 'postedBy'],

        ];

        $customFieldsList = BaseService::getInstance()->getCustomFields('job');

        foreach ($customFieldsList as $customField) {
            $reportColumns[] = [
                'label' => $customField->field_label,
                'column' => $customField->name,
            ];
        }

        $entries = BaseService::getInstance()->get('Job', null, $filters);
        $data = [];
        foreach ($entries as $item) {
            $item =  BaseService::getInstance()->enrichObjectMappings($mapping, $item);
            $item =  BaseService::getInstance()->enrichObjectCustomFields('Job', $item);
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
