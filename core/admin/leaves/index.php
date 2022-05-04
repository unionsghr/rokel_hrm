<?php
/*
 Copyright (c) 2018 [Glacies UG, Berlin, Germany] (http://glacies.de)
 Developer: Thilina Hasantha (http://lk.linkedin.com/in/thilinah | https://github.com/thilinah)
 */
 
$moduleName = 'leaves';
$moduleGroup = 'admin';
define('MODULE_PATH',dirname(__FILE__));
include APP_BASE_PATH.'header.php';
include APP_BASE_PATH.'modulejslibs.inc.php';

$leavePeriod = \Leaves\Common\Model\LeavePeriod::getCurrentLeavePeriod()->getData();
if(!empty($leavePeriod)){
	$leavePeriodId = $leavePeriod->id;
}

$moduleBuilder = new \Classes\ModuleBuilder\ModuleBuilder();

$options1 = array();
$options1['setRemoteTable'] = 'true';

$options2 = array();
$options2['setCountryBasedLeavePeriods'] = \Leaves\Admin\Api\LeaveUtil::isCountryBasedLeavePeriodsEnabled()
    ? 'true' : 'false';

$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'LeaveType',
	'LeaveType',
	'Leave Types',
	'LeaveTypeAdapter',
	'',
	'',
	true
));
$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'LeavePeriod',
	'LeavePeriod',
	'Leave Period',
	'LeavePeriodAdapter',
	'',
	'',
    false,
    $options2
));
$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'WorkDay',
	'WorkDay',
	'Work Week',
	'WorkDayAdapter',
	'',
	''
));

$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'HoliDay',
	'HoliDay',
	'Holidays',
	'HoliDayAdapter',
	'',
	'',
	false,
	$options1
));

$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'LeaveRule',
	'LeaveRule',
	'Leave Rules',
	'LeaveRuleAdapter',
	'',
	''
));
// $moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
// 	'LeaveAllowance',
// 	'LeaveAllowance',
// 	'Leave Allowance',
// 	'LeaveStartingBalanceAdapter',
// 	'',
// 	''
// ));

// $moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
// 	'LeaveStartingBalance',
// 	'LeaveStartingBalance',
// 	'Paid Time Off',
// 	'LeaveStartingBalanceAdapter',
// 	'',
// 	''
// ));


$moduleGroup1 = new \Classes\ModuleBuilder\ModuleTabGroup(
	'leaveGroupMenu',
	'Leave Groups'
);
$moduleGroup1->addModuleTab(new \Classes\ModuleBuilder\ModuleTab(
	'LeaveGroup',
	'LeaveGroup',
	'Edit Leave Groups',
	'LeaveGroupAdapter',
	'',
	''
));
$moduleGroup1->addModuleTab(new \Classes\ModuleBuilder\ModuleTab(
	'LeaveGroupEmployee',
	'LeaveGroupEmployee',
	'Leave Group Employees',
	'LeaveGroupEmployeeAdapter',
	'',
	'leave_group'
));

$moduleBuilder->addModuleOrGroup($moduleGroup1);

$options2 = array();
$options2['setRemoteTable'] = 'true';
$options2['setShowAddNew'] = 'false';
$options2['preSetFilterExternal'] = '{"status":"Pending","leave_period":"' . $leavePeriodId . '"}';
$moduleBuilder->addModuleOrGroup(new \Classes\ModuleBuilder\ModuleTab(
	'EmployeeLeave',
	'EmployeeLeave',
	'Employee Leave List',
	'EmployeeLeaveAdapter',
	'',
	'date_start desc',
	false,
	$options2
));

echo \Classes\UIManager::getInstance()->renderModule($moduleBuilder);
?>

<div class="modal" id="leaveStatusModel" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><li class="fa fa-times"/></button>
		<h3 style="font-size: 17px;"><?=t('Change Leave Status')?></h3>
	</div>
	<div class="modal-body">
		<form id="leaveStatusForm">
		<div class="control-group">
			<label class="control-label" for="leave_status"><?=t('Leave Status')?></label>
			<div class="controls">
			  	<select type="text" id="leave_status" class="form-control" name="leave_status" value="">
				  	<option value="Approved">Approved</option>
				  	<option value="Pending">Pending</option>
				  	<option value="Rejected">Rejected</option>
				  	<option value="Cancelled">Cancelled</option>
			  	</select>
			</div> 
		</div>
		<div class="control-group">
							<label class="control-label" for="employee_id"><?=$itemName?> ID</label>
							<div class="controls">
							<input type="text" class="form-control" id="<?=$itemNameLower?>_employee_Id"  name ="<?=$itemNameLower?>_employee_Id">
							
								</select>
							</div>
						</div>
		<div class="control-group">
			<label class="control-label" for="leave_status"><?=t('Status Change Note')?></label>
			<div class="controls">
			  	<textarea id="leave_reason" class="form-control" name="leave_reason" maxlength="500"></textarea>
			</div>
		</div>
		</form>
	</div>
	<div class="modal-footer">
 		<button class="btn btn-primary" onclick="modJs.changeLeaveStatus();"><?=t('Change Leave Status')?></button>
 		<button class="btn" onclick="modJs.closeLeaveStatus();"><?=t('Cancel')?></button>
	</div>
</div> 
</div>
</div>

<?php include APP_BASE_PATH.'footer.php';?>
