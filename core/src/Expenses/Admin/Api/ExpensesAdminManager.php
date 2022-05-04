<?php
namespace Expenses\Admin\Api;

use Classes\AbstractModuleManager;
use Expenses\Rest\ExpensesRestEndPoint;

class ExpensesAdminManager extends AbstractModuleManager
{

    public function initializeUserClasses()
    {
        if (defined('MODULE_TYPE') && MODULE_TYPE != 'admin') {
            $this->addUserClass("EmployeeExpense");
        }
    }

    public function initializeFieldMappings()
    {
        $this->addFileFieldMapping('EmployeeExpense', 'attachment1', 'name');
        $this->addFileFieldMapping('EmployeeExpense', 'attachment2', 'name');
        $this->addFileFieldMapping('EmployeeExpense', 'attachment3', 'name');
    }

    public function initializeDatabaseErrorMappings()
    {
    }

    public function setupModuleClassDefinitions()
    {

        $this->addModelClass('ExpensesCategory');
        $this->addModelClass('ExpensesPaymentMethod');
        $this->addModelClass('ExpensesBusinessPurpose');        
        $this->addModelClass('EmployeeExpense');
        $this->addModelClass('EmployeeExpenseApproval');
        $this->addModelClass('Vw_EmployeeImprest');
    }

    public function initCalculationHooks()
    {
        $this->addCalculationHook(
            'ExpensePayrollUtils_getApprovedExpensesTotal',
            'Total Approved Expenses',
            ExpensePayrollUtils::class,
            'getApprovedExpensesTotal'
        );
    }

    public function setupRestEndPoints()
    {
        \Classes\Macaw::get(REST_API_PATH.'expenses', function () {
            $restEndPoint = new ExpensesRestEndPoint();
            $restEndPoint->process('getUserExpenses', []);
        });

        \Classes\Macaw::post(REST_API_PATH.'expense', function () {
            $restEndPoint = new ExpensesRestEndPoint();
            $restEndPoint->process('addExpense', []);
        });

        \Classes\Macaw::get(REST_API_PATH.'expense/categories', function ($pathParams) {
            $restEndPoint = new ExpensesRestEndPoint();
            $restEndPoint->process('getExpenseCategories', $pathParams);
        });

        \Classes\Macaw::get(REST_API_PATH.'expense/payment-methods', function ($pathParams) {
            $restEndPoint = new ExpensesRestEndPoint();
            $restEndPoint->process('getExpensePaymentMethods', $pathParams);
        });
    
        \Classes\Macaw::post(REST_API_PATH.'expenses/file-upload', function () {
            $restEndPoint = new ExpensesRestEndPoint();
            $restEndPoint->process('uploadFile', []);
        });
    }
}
