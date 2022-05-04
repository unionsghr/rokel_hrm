<?php
namespace Reports\Admin\Reports;
use Company\Common\Model\CompanyStructure;
use Reports\Admin\Api\CSVReportBuilder;
use Reports\Admin\Api\CSVReportBuilderInterface;
use Utils\LogManager;

class MedicalEntitlementReport extends CSVReportBuilder implements CSVReportBuilderInterface
{
  
    public function getMainQuery()
    { 
        $query = "SELECT 
        employee as 'EMPLOYEE',
        (select name from paygrades where id = grade) as 'GRADE',
        amount as 'MEDICAL LIMIT (SLL)',
        consumption as 'AMOUNT UTILIZED (SLL)',
        balance as 'BALANCE (SLL)'
                
        FROM medenquiry";

        return $query;
        
    }

    public function getWhereQuery($request)
    {

        $employeeList = array();
        if (!empty($request['employee'])) {
            $employeeList = json_decode($request['employee'], true);
        }

        if (in_array("NULL", $employeeList)) {
            $employeeList = array();
        }

        // if (!empty($employeeList) && ($request['status'] != "NULL" && !empty($request['status']))) {
        //     $query = "where employee in (".implode(",", $employeeList)
        //         .") and date(from_date) >= ? and date(to_date) <= ? and status = ?;";
        //     $params = array(
        //         $request['from_date'],
        //         $request['to_date'],
        //         $request['status']
        //     );
        // } elseif (!empty($employeeList)) {
        //     $query = "where employee in (".implode(",", $employeeList)
        //         .") and date(from_date) >= ? and date(to_date) <= ?;";
        //     $params = array(
        //         $request['from_date'],
        //         $request['to_date']
        //     );
        // } elseif (($request['status'] != "NULL" && !empty($request['status']))) {
        //     $query = "where status = ? and date(from_date) >= ? and date(to_date) <= ?;";
        //     $params = array(
        //         $request['status'],
        //         $request['from_date'],
        //         $request['to_date']
        //     );
        // } else {
        //     $query = "where date(from_date) >= ? and date(to_date) <= ?;";
        //     $params = array(
        //         $request['from_date'],
        //         $request['to_date']
        //     );
        // }

        return array($query, $params);
    }
}
