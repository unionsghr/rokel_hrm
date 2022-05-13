<?php

/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/20/17
 * Time: 7:46 AM
 */

namespace EmployeeTransfers\Admin\Api;

use Classes\AbstractModuleManager;
use EmployeeTransfers\Common\Model\EmployeeTransfer;

class EmployeeTransferAdminManager extends AbstractModuleManager
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

        $this->addModelClass('EmployeeTransfer');
    }

}
