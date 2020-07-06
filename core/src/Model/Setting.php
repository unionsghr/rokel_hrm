<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/21/17
 * Time: 2:33 AM
 */

namespace Model;

use Classes\BaseService;
use Classes\IceResponse;
use Classes\RestApiManager;
use Users\Common\Model\User;

class Setting extends BaseModel
{
    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }

    public function getManagerAccess()
    {
        return array();
    }

    public function getUserAccess()
    {
        return array();
    }

    public function postProcessGetElement($obj)
    {
        if ($obj->name == 'Api: REST Api Token') {
            $user = BaseService::getInstance()->getCurrentUser();
            $dbUser = new User();
            $dbUser->Load("id = ?", array($user->id));
            $resp = RestApiManager::getInstance()->getAccessTokenForUser($dbUser);
            $obj->value = $resp->getData();
        }
        return $obj;
    }

    public function validateSave($obj)
    {
        if (!defined('WEB_ADMIN_BASE_URL')) {
            return new IceResponse(IceResponse::SUCCESS, "");
        }

        if ($obj->name == 'Company: Country') {
            $updateInvUrl = WEB_ADMIN_BASE_URL.'/app/update_instance.php?client='
                .CLIENT_NAME.'&country='.$obj->value.'&key='.ADMIN_SEC_KEY;
            $response = file_get_contents($updateInvUrl);
        }

        if ($obj->name == 'Company: Vat ID') {
            $updateInvUrl = WEB_ADMIN_BASE_URL.'/app/update_instance.php?client='
                .CLIENT_NAME.'&vatId='.$obj->value.'&key='.ADMIN_SEC_KEY;
            $response = file_get_contents($updateInvUrl);
            $response = json_decode($response, true);
            if ($response['status'] === IceResponse::ERROR) {
                return new IceResponse(IceResponse::ERROR, $response['data']);
            }
        }
        return new IceResponse(IceResponse::SUCCESS, "");
    }

    public function executePreSaveActions($obj)
    {
        if ($obj->name == 'Leave: Select Leave Period from Employee Department Country') {
            $oldSetting = new Setting();
            $oldSetting->Load('name = ?', ['Leave: Select Leave Period from Employee Department Country']);
            if (class_exists('\Leaves\Common\Model\EmployeeLeave')) {
                $employeeLeave = new \Leaves\Common\Model\EmployeeLeave();
                $employeeLeaves = $employeeLeave->Find("1 = 1 limit 1", []);
                if (count($employeeLeaves) === 1) {
                    $obj->value = $oldSetting->value;
                }
            }
        }

        return new IceResponse(IceResponse::SUCCESS, $obj);
    }

    public function executePreUpdateActions($obj)
    {
        return $this->executePreSaveActions($obj);
    }

    public function executePostSaveActions($obj)
    {
    }

    public function executePostUpdateActions($obj)
    {
    }

    public $table = 'Settings';
}
