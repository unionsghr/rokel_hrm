<?php
namespace Reports\Admin\Reports;
use Company\Common\Model\CompanyStructure;
use Reports\Admin\Api\CSVReportBuilder;
use Reports\Admin\Api\CSVReportBuilderInterface;
use Utils\LogManager;

class GlReport extends CSVReportBuilder implements CSVReportBuilderInterface
{
  
    public function getMainQuery()
    { 
        $query = "SELECT 
        (SELECT name from payroll where id = payroll) as 'PAYROLL',
        component as 'COMPONENT',
        component_gl as 'GL',
        (select title from companystructures where comp_code = branch) as 'BRANCH',
        amount as 'AMOUNT(SLL)'
        -- nassit_no as 'NASSIT No.',
        -- (NVL(basic, 0) + NVL(casual_labour, 0)) as 'BASIC SALARY',
        -- -- basic as 'BASIC SALARY',
        -- -- NVL(gross_salary, 0) as 'GROSS SALARY',
        -- NVL(nassit_5, 0) + NVL(nassits_contr, 0) as 'EMPLOYEE NASSIT',
        -- NVL(nassit10_deduct, 0) + NVL( 	nassit10_dedt_contr, 0) as 'EMPLOYER NASSIT',
        -- -- NVL(nassits_contr, 0) as 'EMPLOYEE NASSIT (contract)',
        -- -- NVL(nassit10_dedt_contr, 0) as 'EMPLOYER NASSIT (contract)',
        -- (NVL(nassit_5, 0) + NVL(nassit10_deduct, 0) + NVL(nassits_contr, 0) + NVL(nassit10_dedt_contr, 0)) as 'TOTAL'        
        FROM vw_gl_summary ";

        return $query;
        
    }

    public function getWhereQuery($request)
    {
        $query = "";
        $params = array();

        {
            $depts = $this->getChildCompanyStuctures($request['payroll']);
            $query = "where payroll in (".implode(",", $depts)
                .")";
        }


        return array($query, $params);
    }

    public function getChildCompanyStuctures($companyStructId)
    {
        $childIds = array();
        $childIds[] = $companyStructId;
        $nodeIdsAtLastLevel = $childIds;
        $count = 0;

        return $childIds;
    }
}
