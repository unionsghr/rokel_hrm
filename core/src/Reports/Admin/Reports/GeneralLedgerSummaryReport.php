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

class GeneralLedgerSummaryReport extends ClassBasedReportBuilder implements ReportBuilderInterface
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
            "branch_code" => ["CompanyStructure","comp_code","title"],
            
            // "employee" => ["Employee","id","first_name+middle_name+last_name"],
            
            "type" => ["AssetType","id","name"],
            "notch" => ["Notches", "id", "name"],
            "account_no" => ["Salaries","account_no","prefix+account_no"],
            // "branch_code" => ["Paygrades", "id", "name"],
        ];

        $reportColumns = [
            ['label' => 'BRANCH', 'column' => 'branch_code'],
            ['label' => 'COMPONENT', 'column' => 'component_type'],
            ['label' => 'AMOUNT (SLL)', 'column' => 'component_amount'],
            ['label' => 'GENERAL LEDGER', 'column' => 'general_ledger'],
            ['label' => 'FLAG', 'column' => 'flag'],
            ['label' => 'GROUP', 'column' => 'status'],
            
        ];

        $customFieldsList = BaseService::getInstance()->getCustomFields('Gl_summary');

        foreach ($customFieldsList as $customField) {
            $reportColumns[] = [
                'label' => $customField->field_label,
                'column' => $customField->name,
            ];
        }

        $entries = BaseService::getInstance()->get('Gl_summary', null, $filters);

    // LogManager::getInstance()->info("=========>".implode(",", $entries)."<========");
       
        $data = [];
        foreach ($entries as $item) {
            $item =  BaseService::getInstance()->enrichObjectMappings($mapping, $item);
            $item =  BaseService::getInstance()->enrichObjectCustomFields('Gl_summary', $item);
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
