<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/20/17
 * Time: 7:46 AM
 */

namespace Medical\Admin\Api;

use Classes\AbstractModuleManager;
use Medical\Common\Model\StaffMedical;

class MedicalAdminManager extends AbstractModuleManager
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

        $this->addModelClass('StaffMedical');
        $this->addModelClass('DependentMedical');
        $this->addModelClass('MedicalLimit');
        $this->addModelClass('WorkInjuries');
        $this->addModelClass('MedEnquiry');
    }

    // public function getDashboardItemData()
    // {
    //     $data = array();
    //     $course = new Course();
    //     $data['numberOfCourses'] = $course->Count("1 = 1");
    //     return $data;
    // }
}
