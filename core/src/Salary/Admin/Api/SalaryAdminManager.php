<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 11:09 PM
 */

namespace Salary\Admin\Api;

use Classes\AbstractModuleManager;

class SalaryAdminManager extends AbstractModuleManager
{

    public function initializeUserClasses()
    {
    }

    public function initializeFieldMappings()
    {
    }

    public function initializeDatabaseErrorMappings()
    {
    }

    public function setupModuleClassDefinitions()
    {
        $this->addModelClass('SalaryComponentType');
        $this->addModelClass('SalaryComponent');
        $this->addModelClass('PayrollEmployee');
        $this->addModelClass('Notches'); 
        $this->addModelClass('Salaries'); 
        $this->addModelClass('Salaries1'); 
        $this->addModelClass('Salaries_view');  
        $this->addModelClass('Salaries_contract');    
        $this->addModelClass('Salaries_permanent');
        $this->addModelClass('Gl_summary');
        $this->addModelClass('Vw_EmployeeSalary');
        $this->addModelClass('Vw_Final_Salaries');
        $this->addModelClass('Benefits');
        $this->addModelClass('PaymentType'); 
       
    }
}
