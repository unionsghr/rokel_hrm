<?php
namespace Reports\Admin\Reports;
use Company\Common\Model\CompanyStructure;
use Reports\Admin\Api\CSVReportBuilder;
use Reports\Admin\Api\CSVReportBuilderInterface;
use Utils\LogManager;

class StaffMedicalReport extends CSVReportBuilder implements CSVReportBuilderInterface
{
  
    public function getMainQuery()
    { 
        $query = "SELECT 
        (select concat(first_name,' ', middle_name, ' ', last_name) from employees where id = employee) as 'EMPLOYEE',
        from_date as 'DATE ATTENDED',
        to_date as 'DATE DISCHARGED',
        admission_type as 'ADMISSION TYPE',
        type_of_illness as 'ILLNESS',
        medication_given as 'MEDICATION',
        hospital as 'HOSPITAL',
        physician as 'PHYSICIAN',
        NVL(cost, 0) as 'COST',
        status as 'STATUS',
        approved_date as 'APPROVED DATE',
        (select concat(first_name,' ', middle_name, ' ', last_name) from employees where id = approved_by) 'APPROVED BY',
        reference as 'POSTING REFERENCE'        
        FROM staffmedical ";

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
