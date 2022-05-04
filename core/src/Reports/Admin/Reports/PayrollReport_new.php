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

class PayrollReport extends ClassBasedReportBuilder implements ReportBuilderInterface
// class PayrollReport extends ClassBasedReportBuilder implements CSVReportBuilder
// class PayrollReport extends ReportBuilder
{
 
    public function getData($report, $request)
    {
        $filters = [];

        if (!empty($request['payroll']) && $request['payroll'] !== "NULL") {
            $filters['payroll'] = $request['payroll'];
        }

        if (!empty($request['type']) && $request['type'] !== "NULL") {
            $filters['type'] = $request['type'];
        }

        $mapping = [
            "department" => ["CompanyStructure","id","title"],
            
            "employee" => ["Employee","id","first_name+middle_name+last_name"],
            
            "type" => ["AssetType","id","name"],
            "notches" => ["Notches", "id", "name"],
            "account_no" => ["Salaries","account_no","prefix+account_no"],
            "pay_grade" => ["PayGrade", "id", "name"],
            // "payroll" => ["Payroll", "id", "name"],
            "employment_status" => ["EmploymentStatus", "id", "name"],
        ];
 
        $reportColumns = [
            ['label' => 'EMPLOYEE ID', 'column' => 'employee_id'],
            ['label' => 'FIRST NAME', 'column' => 'first_name'],
            ['label' => 'MIDDLE NAME', 'column' => 'middle_name'],
            ['label' => 'LAST NAME', 'column' => 'last_name'],
            // ['label' => 'EMPLOYEE NAME', 'column' => 'employee'],
            ['label' => 'PAY GRADE', 'column' => 'pay_grade'],
            ['label' => 'NOTCH', 'column' => 'notches'],
            ['label' => 'ACCOUNT NUMBER', 'column' =>'bank_acc_no'],
            // ['label' => 'BRANCH CODE', 'column' =>'branch_code'],
            ['label' => 'BASIC SALARY', 'column' => 'basic'],
            ['label' => 'CAR ALLOWANCE', 'column' => 'car'],
            ['label' => 'HONORARIUM', 'column' => 'honorarium'],
            ['label' => 'TRANSPORT', 'column' => 'transport'],
            ['label' => 'LUNCH', 'column' => 'lunch'],
            // ['label' => 'Rent Witheld', 'column' => 'rent_witheld'],
            ['label' => 'RENT', 'column' => 'monthly_rent'],
            ['label' => 'GROSS INCOME', 'column' => 'gross_salary'],
            ['label' => 'EMPLOYEE NASSIT', 'column' => 'nassit_5'],
            ['label' => 'EMPLOYER NASSIT', 'column' => 'nassit10_deduct'],
            ['label' => 'MEDICAL EXCESS', 'column' => 'medical_excess'],
            ['label' => 'UNION DUES', 'column' => 'union_dues'],
            ['label' => 'PAYE', 'column' => 'paye'],
            ['label' => 'WITHOLDING TAX', 'column' => 'witholding_tax'],
            ['label' => 'TOTAL DEDUCTION', 'column' => 'total_deduction'],
            ['label' => 'NET SALARY', 'column' => 'net_salary'],
            ['label' => 'EMPLOYMENT STATUS', 'column' => 'employment_status'],
        ];

        $customFieldsList = BaseService::getInstance()->getCustomFields('Vw_Final_Salaries');

        foreach ($customFieldsList as $customField) {
            $reportColumns[] = [
                'label' => $customField->field_label,
                'column' => $customField->name,
            ];
        }

        $entries = BaseService::getInstance()->get('Vw_Final_Salaries', null, $filters);

    // LogManager::getInstance()->info("=========>".implode(",", $entries)."<========");
       
        $data = [];
        foreach ($entries as $item) {
            $item =  BaseService::getInstance()->enrichObjectMappings($mapping, $item);
            $item =  BaseService::getInstance()->enrichObjectCustomFields('Vw_Final_Salaries', $item);
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

    public function getWhereQuery($request)
    {
        $query = "";
        $params = array();

        // if (empty($request['department']) || $request['department'] == "NULL") {
        //     $params = array();
        //     $query = "where ((termination_date is NULL or termination_date = '0001-01-01 00:00:00' 
        //     or termination_date = '0000-00-00 00:00:00') and recruitment_date < NOW()) or 
        //     (termination_date > NOW() and recruitment_date < NOW())";
        // } else 
        {
            $depts = $this->getChildCompanyStuctures($request['payroll']);
            $query = "where payroll in (".implode(",", $depts)
                .")"; 
                // and (((termination_date is NULL or termination_date = '0001-01-01 00:00:00' 
                // or termination_date = '0000-00-00 00:00:00') and recruitment_date < NOW()) 
                // or (termination_date > NOW() and recruitment_date < NOW()))";
        }


        return array($query, $params);
    }

    public function getChildCompanyStuctures($companyStructId)
    {
        $childIds = array();
        $childIds[] = $companyStructId;
        $nodeIdsAtLastLevel = $childIds;
        $count = 0;
        // do {
        //     $count++;
        //     $companyStructTemp = new CompanyStructure();
        //     if (empty($nodeIdsAtLastLevel) || empty($childIds)) {
        //         break;
        //     }
        //     $idQuery = "parent in (".implode(",", $nodeIdsAtLastLevel).") and id not in(".implode(",", $childIds).")";
        //     LogManager::getInstance()->debug($idQuery);
        //     $list = $companyStructTemp->Find($idQuery, array());
        //     if (!$list) {
        //         LogManager::getInstance()->debug($companyStructTemp->ErrorMsg());
        //     }
        //     $nodeIdsAtLastLevel = array();
        //     foreach ($list as $item) {
        //         $childIds[] = $item->id;
        //         $nodeIdsAtLastLevel[] = $item->id;
        //     }
        // } while (count($list) > 0 && $count < 10);

        return $childIds;
    }
}
