<?php
namespace Reports\User\Reports;
use Classes\BaseService;
use Utils\LogManager;
use Reports\Admin\Api\CSVReportBuilder;
use Reports\Admin\Api\CSVReportBuilderInterface;

class NASSITReport extends CSVReportBuilder implements CSVReportBuilderInterface
{

    public function getMainQuery()
    { 
        $employee = BaseService::getInstance()->getElement(
            'Employee',
            BaseService::getInstance()->getCurrentProfileId(),
            null,
            true
        );
        $query = "SELECT (SELECT name from Payroll where id = vw_final_salaries.payroll) as 'PAYROLL',  first_name as 'FIRST NAME', middle_name as 'MIDDLE NAME',
        last_name as 'LAST NAME', bank_acc_no as 'ACCOUNT NUMBER', nassit_no as 'NASSIT No.',      
        basic as 'BASIC SALARY',
        gross_salary as 'GROSS SALARY',
        NVL(nassit_5, 0) as 'EMPLOYEE NASSIT',
        -- nassit_5 as 'EMPLOYEE NASSIT',
        NVL(nassit10_deduct, 0) as 'EMPLOYER NASSIT', (SELECT (NVL(nassit_5, 0) + NVL(nassit10_deduct, 0))) as 'TOTAL'
        FROM vw_final_salaries";

        return $query;
    }

    // public function getWhereQuery($request)
    // {
    //     $query = "";
    //     $params = array(); 
    //     {
    //         $depts = $this->getChildCompanyStuctures($request['payroll']);
    //         $query = "where payroll in (".implode(",", $depts)
    //             .")";
    //     }


    //     return array($query, $params);
    // }


    public function getWhereQuery($request)
    {

        $query = "where employee = ? and date_start >= ? and date_end <= ? order by date_start desc";
      $params = array(
                BaseService::getInstance()->getCurrentProfileId(),
                $request['date_start']." 00:00:00",
                $request['date_end']." 23:59:59",
        );
  
        LogManager::getInstance()->info("Query:".$query);
        LogManager::getInstance()->info("Params:".json_encode($params));

        return array($query, $params);
    }


}
