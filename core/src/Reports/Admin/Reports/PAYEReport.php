<?php
namespace Reports\Admin\Reports;

use Company\Common\Model\CompanyStructure;
use Reports\Admin\Api\CSVReportBuilder;
use Reports\Admin\Api\CSVReportBuilderInterface;
use Utils\LogManager;

class PAYEReport extends CSVReportBuilder implements CSVReportBuilderInterface
{
  
    public function getMainQuery()
    { 

        $query = "SELECT 
        tin_no as 'TIN NUMBER',
        employee_id as 'EMPLOYEE ID',
        -- first_name as 'FIRST NAME',
        -- middle_name as 'MIDDLE NAME',
        -- last_name as 'LAST NAME',
        (SELECT CONCAT(first_name, ' ', middle_name, ' ', last_name )) as 'EMPLOYEE NAME',
        birthday as 'DATE OF BIRTH',
        gender as 'GENDER',
        job_title as 'DESIGNATION',
        
        -- (SELECT name from PayGrades where id = pay_grade) as 'PAY GRADE',
        -- (SELECT name from Notches where id = notches) as 'NOTCH',
        -- bank_acc_no as 'ACCOUNT NUMBER',
        -- nassit_no as 'NASSIT No.',
        -- (SELECT br_description from Branches where br_code = branch) as 'BRANCH',        
        (NVL(basic, 0) + NVL(casual_labour, 0)) as 'BASIC SALARY',
        NVL(null,0) as 'RENT ALLOWANCE',
        NVL(overtime,0) as 'OVERTIME',
        NVL(null,0) as 'COMMISSION',
        NVL(null,0) as 'PAYMENT IN LIEU OF NOTICE',
        (NVL(duty_allowance, 0) + NVL(lunch, 0) + NVL(stewards_allowance, 0) + NVL(displacement_allowance, 0) + NVL(audit_allowance, 0) + NVL(word_processing, 0) + NVL(sundry_allowance, 0) + NVL(car_allowance, 0)) + NVL(allowances_contr, 0) as 'OTHER ALLOWANCES',
        NVL(null,0) as 'LEAVE PASSAGE ALLOWANCE',
        NVL(null,0) as 'BONUS',
        NVL(null,0) as 'LEAVE ALLOWANCE IN EXCESS OF BASIC SALARY',
        NVL(null,0) as 'BENEFIT IN KIND',
        NVL(transport,0) as 'TRANSPORT',
        NVL(null,0) as 'CLOTHING ALLOWANCE',
        NVL(null,0) as 'STIPEND',
        NVL(null,0) as 'OTHER INCOME',
        (NVL(nassit_5, 0) + NVL(nassits_contr, 0)) as 'NASSIT CONTRIBUTION',
        (NVL(gross_salary,0) + NVL(gross_salary_contr,0)) as 'GROSS INCOME',
        NVL(taxable_income,0) + NVL(gross_an_contr,0) as 'TAXABLE INCOME',
        (NVL(paye,0) + NVL(witholding_tax,0)) as 'PAYE'



        -- honorarium as 'HONORARIUM',
        -- transport as 'TRANSPORT',
        -- lunch as 'LUNCH',
        -- monthly_rent as 'RENT',
        -- gross_salary as 'GROSS SALARY',
        -- nassit_5 as 'EMPLOYEE NASSIT',
        -- nassit10_deduct as 'EMPLOYER NASSIT',
        -- medical_excess as 'MEDICAL EXCESS',
        -- union_dues as 'UNION DUES',            
        -- paye as 'PAYE'
        -- witholding_tax as 'WITHOLDING TAX',
        -- total_deduction as 'TOTAL DEDUCTION',
        -- net_salary as 'NET SALARY',
        -- (SELECT name from EmploymentStatus where id = employment_status) as 'EMPLOYMENT STATUS'
        -- payroll as 'PAYROLL'
        
        
        FROM vw_final_salaries ";

        return $query;
        
    }

    public function getWhereQuery($request)
    {
        $query = "";
        $params = array();

        // if ($request['employment_status']){
        //     $params = array();
        //     // $query = "where ((termination_date is NULL or termination_date = '0001-01-01 00:00:00' 
        //     // or termination_date = '0000-00-00 00:00:00') and recruitment_date < NOW()) or 
        //     // (termination_date > NOW() and recruitment_date < NOW())";
        //     $emp_status = $this->getChildCompanyStuctures($request['employment_status']);
        //     $query = "where employment_status in (".implode(",", $emp_status)
        //         .")";
        // } else 
        {
            $depts = $this->getChildCompanyStuctures($request['payroll']);
            $query = "where payroll in (".implode(",", $depts)
                .")";
                //  and (((termination_date is NULL or termination_date = '0001-01-01 00:00:00' 
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
