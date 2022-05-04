<?php
namespace Reports\Admin\Reports;

use Classes\BaseService;
use Reports\Admin\Api\ClassBasedReportBuilder;
use Reports\Admin\Api\ReportBuilderInterface;
use Payroll\Common\Model\Payroll;
use Jobs\Common\Model\PayGrades;
use Payroll\Common\Model\PayrollColumn;
use Payroll\Common\Model\PayrollData;
use Payroll\Common\Model\PayslipTemplate;
use Reports\Admin\Api\PDFReportBuilder;
use Reports\Admin\Api\PDFReportBuilderInterface;
use Utils\LogManager;

class PayrollReportContract extends ClassBasedReportBuilder implements ReportBuilderInterface
// class PayrollReport extends ClassBasedReportBuilder implements CSVReportBuilder
// class PayrollReport extends ReportBuilder
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
            
            // "employee" => ["Employee","id","first_name+middle_name+last_name"],
            
            "type" => ["AssetType","id","name"],
            "notch" => ["Notches", "id", "name"],
            "account_no" => ["Salaries","account_no","prefix+account_no"],
            // "pay_grade" => ["Paygrades", "id", "name"],
        ];

        $reportColumns = [
            ['label' => 'EMPLOYEE ID', 'column' => 'emp_id'],
            ['label' => 'FIRST NAME', 'column' => 'first_name'],
            ['label' => 'MIDDLE NAME', 'column' => 'middle_name'],
            ['label' => 'LAST NAME', 'column' => 'last_name'],
            // ['label' => 'EMPLOYEE NAME', 'column' => 'employee'],
            // ['label' => 'PAY GRADE', 'column' => 'pay_grade'],
            // ['label' => 'NOTCH', 'column' => 'notch'],
            ['label' => 'ACCOUNT NUMBER', 'column' =>'account_no'],
            ['label' => 'BRANCH CODE', 'column' =>'branch_code'],
            ['label' => 'BASIC SALARY', 'column' => 'basic_salary'],
            // ['label' => 'CAR ALLOWANCE', 'column' => 'car_allowance'],
            // ['label' => 'HONORARIUM', 'column' => 'honorarium'],
            // ['label' => 'TRANSPORT', 'column' => 'transport'],
            // ['label' => 'LUNCH', 'column' => 'lunch'],
            // ['label' => 'Rent Witheld', 'column' => 'rent_witheld'],
            // ['label' => 'RENT', 'column' => 'monthly_rent'],
            // ['label' => 'GROSS INCOME', 'column' => 'gross_salary'],
            ['label' => 'EMPLOYEE NASSIT', 'column' => 'nassit'],
            ['label' => 'EMPLOYER NASSIT', 'column' => 'employer_nassit'],
            // ['label' => 'MEDICAL EXCESS', 'column' => 'medical_excess'],
            // ['label' => 'UNION DUES', 'column' => 'union_dues'],
            // ['label' => 'PAYE', 'column' => 'paye'],
            ['label' => 'WITHOLDING TAX', 'column' => 'witholding_tax'],
            ['label' => 'TOTAL DEDUCTION', 'column' => 'total_deduction'],
            ['label' => 'NET SALARY', 'column' => 'net_salary'],
            ['label' => 'EMPLOYMENT STATUS', 'column' => 'status'],
        ];

        $customFieldsList = BaseService::getInstance()->getCustomFields('Salaries_contract');

        foreach ($customFieldsList as $customField) {
            $reportColumns[] = [
                'label' => $customField->field_label,
                'column' => $customField->name,
            ];
        }

        $entries = BaseService::getInstance()->get('Salaries_contract', null, $filters);

    // LogManager::getInstance()->info("=========>".implode(",", $entries)."<========");
       
        $data = [];
        foreach ($entries as $item) {
            $item =  BaseService::getInstance()->enrichObjectMappings($mapping, $item);
            $item =  BaseService::getInstance()->enrichObjectCustomFields('Salaries_contract', $item);
            $data[] = $item;
        }

        // LogManager::getInstance()->info("========>".implode(",", $item)."<========");

        $mappedColumns = array_keys($mapping);
        
        $reportData = [];
        $reportData[] = array_column($reportColumns, 'label');

// LogManager::getInstance()->info("=========>".implode(",", $reportData)."<========");

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
// LogManager::getInstance()->info("=========>".implode(",", $reportData)."<========");

        return $reportData;
    }
}
