<?php
namespace Reports\Admin\Reports;
use Classes\BaseService;
use Reports\Admin\Api\ClassBasedReportBuilder;
use Reports\Admin\Api\ReportBuilderInterface;

class NASSITcontractReport extends ClassBasedReportBuilder implements ReportBuilderInterface
{

    public function getData($report, $request)
    {
        $filters = [];

        if (!empty($request['department']) && $request['department'] !== "NULL") {
            $filters['department'] = $request['department'];
        }

        if (!empty($request['type']) && $request['type'] !== "NULL") {
            $filters['type'] = $request['type'];
        }

        $mapping = [
            "department" => ["CompanyStructure","id","title"],
            "employee" => ["Employee","id","first_name+middle_name+last_name"],
            "type" => ["AssetType","id","name"],
            "notch" => ["Notches", "id", "name"],
        ];

        $reportColumns = [
            ['label' => 'FIRST NAME', 'column' => 'first_name'],
            ['label' => 'OTHER NAME', 'column' => 'middle_name'],
            ['label' => 'LAST NAME', 'column' => 'last_name'],
            ['label' => 'NASSIT NUMBER', 'column' => 'nassit_no'],
            ['label' => 'BASIC SALARY', 'column' => 'basic_salary'],
            ['label' => 'EMPLOYEE NASSIT (5%)', 'column' => 'nassit'],
            ['label' => 'EMPLOYER NASSIT (10%)', 'column' => 'employer_nassit'],
            ['label' => 'TOTAL NASSIT (15%)', 'column' => 'total_nassit'],
           
        ];

        $customFieldsList = BaseService::getInstance()->getCustomFields('Salaries_contract');

        foreach ($customFieldsList as $customField) {
            $reportColumns[] = [
                'label' => $customField->field_label,
                'column' => $customField->name,
            ];
        }

        $entries = BaseService::getInstance()->get('Salaries_contract', null, $filters);
        $data = [];
        foreach ($entries as $item) {
            $item =  BaseService::getInstance()->enrichObjectMappings($mapping, $item);
            $item =  BaseService::getInstance()->enrichObjectCustomFields('Salaries_contract', $item);
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
