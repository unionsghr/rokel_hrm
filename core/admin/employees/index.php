<?php

$moduleName = 'employees';
$moduleGroup = 'admin';
define('MODULE_PATH',dirname(__FILE__));
include APP_BASE_PATH.'header.php';
include APP_BASE_PATH.'modulejslibs.inc.php';
$fieldNameMap = \Classes\BaseService::getInstance()->getFieldNameMappings("Employee");
$customFields = \Classes\BaseService::getInstance()->getCustomFields("Employee");
?><div class="span9">

	<ul class="nav nav-tabs" id="modTab" style="margin-bottom:0px;margin-left:5px;border-bottom: none;">
        <?php if($user->user_level != "Admin"){
        ?>
		    <li class="active"><a id="tabEmployee" href="#tabPageEmployee"><?=t('Employees (Direct Reports)')?></a></li>
        <?php }else{ ?>
            <li class="active"><a id="tabEmployee" href="#tabPageEmployee"><?=t('Employees')?></a></li>
        <?php }?>

		<?php if ($user->user_level == "Admin") { ?>
		<li><a id="tabEmployeeSkill" href="#tabPageEmployeeSkill"><?=t('Skills')?></a></li>
		<li><a id="tabEmployeeEducation" href="#tabPageEmployeeEducation"><?=t('Education')?></a></li>
		<li><a id="tabEmployeeCertification" href="#tabPageEmployeeCertification"><?=t('Certifications')?></a></li>
		<li><a id="tabEmployeeLanguage" href="#tabPageEmployeeLanguage"><?=t('Languages')?></a></li>
		<li><a id="tabEmployeeDependent" href="#tabPageEmployeeDependent"><?=t('Dependents')?></a></li>
		<li><a id="tabEmergencyContact" href="#tabPageEmergencyContact"><?=t('Emergency Contacts')?></a></li>
		<li><a id="tabEmployeeBankDetails" href="#tabPageEmployeeBankDetails"><?=t('General Account Details')?></a></li>
            <?php if (class_exists('\\Documents\\Admin\\Api\\DocumentsAdminManager')) {?>
                <li><a id="tabEmployeeDocument" href="#tabPageEmployeeDocument"><?=t('Documents')?></a></li>
            <?php } ?>
        <?php }?>
        <?php if ($user->user_level == "Admin"){ ?>
        <li class="dropdown">
            <a href="#" id="terminatedEmployeeMenu" class="dropdown-toggle" data-toggle="dropdown" aria-controls="terminatedEmployeeMenu-contents"><?=t('Deactivated Employees')?> <span class="caret"></span></a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="terminatedEmployeeMenu" id="terminatedEmployeeMenu-contents">
                <li><a id="tabTerminatedEmployee" href="#tabPageTerminatedEmployee"><?=t('Suspended Employees')?></a></li>
                <li><a id="tabArchivedEmployee" href="#tabPageArchivedEmployee"><?=t('Terminated Employee Data')?></a></li>
            </ul>
        </li>
        <?php } ?>

	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="tabPageEmployee">
			<div id="Employee" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="EmployeeForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
		<div class="tab-pane" id="tabPageEmployeeBankDetails">
			<div id="EmployeeBankDetails" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="EmployeeBankDetailsForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
		<div class="tab-pane" id="tabPageEmployeeSkill">
			<div id="EmployeeSkill" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="EmployeeSkillForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
		<div class="tab-pane" id="tabPageEmployeeEducation">
			<div id="EmployeeEducation" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="EmployeeEducationForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
		<div class="tab-pane" id="tabPageEmployeeCertification">
			<div id="EmployeeCertification" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="EmployeeCertificationForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
		<div class="tab-pane" id="tabPageEmployeeLanguage">
			<div id="EmployeeLanguage" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="EmployeeLanguageForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
		<div class="tab-pane" id="tabPageEmployeeDependent">
			<div id="EmployeeDependent" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="EmployeeDependentForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
		<div class="tab-pane" id="tabPageEmergencyContact">
			<div id="EmergencyContact" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="EmergencyContactForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>

		<div class="tab-pane" id="tabPageArchivedEmployee">
			<div id="ArchivedEmployee" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="ArchivedEmployeeForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
		<div class="tab-pane" id="tabPageTerminatedEmployee">
			<div id="TerminatedEmployee" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="TerminatedEmployeeForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
        <?php if (class_exists('\\Documents\\Admin\\Api\\DocumentsAdminManager')) {?>
            <div class="tab-pane" id="tabPageEmployeeDocument">
                <div id="EmployeeDocument" class="reviewBlock" data-content="List" style="padding-left:5px;">

                </div>
                <div id="EmployeeDocumentForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

                </div>
            </div>
        <?php } ?>

	</div>

</div>
<script>
var modJsList = new Array();
<?php if($user->user_level != "Admin"){ ?>
modJsList['tabEmployee'] = new EmployeeAdapter('Employee','Employee',{"status":"Active"});
modJsList['tabEmployee'].setShowAddNew(false);
modJsList['tabEmployee'].setShowDelete(false);
<?php }else{ ?>
modJsList['tabEmployee'] = new EmployeeAdapter('Employee','Employee',{"status":"Active"});
<?php } ?>

modJsList['tabEmployee'].setRemoteTable(true);
modJsList['tabEmployee'].setFieldNameMap(<?=json_encode($fieldNameMap)?>);
modJsList['tabEmployee'].setCustomFields(<?=json_encode($customFields)?>);

modJsList['tabEmployeeBankDetails'] = new EmployeeBankDetailsAdapter('EmployeeBankDetails');
modJsList['tabEmployeeBankDetails'].setRemoteTable(true);

modJsList['tabEmployeeSkill'] = new EmployeeSkillAdapter('EmployeeSkill');
modJsList['tabEmployeeSkill'].setRemoteTable(true);

modJsList['tabEmployeeEducation'] = new EmployeeEducationAdapter('EmployeeEducation');
modJsList['tabEmployeeEducation'].setRemoteTable(true);

modJsList['tabEmployeeCertification'] = new EmployeeCertificationAdapter('EmployeeCertification');
modJsList['tabEmployeeCertification'].setRemoteTable(true);

modJsList['tabEmployeeLanguage'] = new EmployeeLanguageAdapter('EmployeeLanguage');
modJsList['tabEmployeeLanguage'].setRemoteTable(true);

modJsList['tabEmployeeDependent'] = new EmployeeDependentAdapter('EmployeeDependent');
modJsList['tabEmployeeDependent'].setRemoteTable(true);

modJsList['tabEmergencyContact'] = new EmergencyContactAdapter('EmergencyContact');
modJsList['tabEmergencyContact'].setRemoteTable(true);

modJsList['tabEmployeeImmigration'] = new EmployeeImmigrationAdapter('EmployeeImmigration');
modJsList['tabEmployeeImmigration'].setRemoteTable(true);

modJsList['tabArchivedEmployee'] = new ArchivedEmployeeAdapter('Employee','ArchivedEmployee',{"status":"Terminated"});
modJsList['tabArchivedEmployee'].setRemoteTable(true);
modJsList['tabArchivedEmployee'].setShowAddNew(false);

modJsList['tabTerminatedEmployee'] = new TerminatedEmployeeAdapter('Employee','TerminatedEmployee',{"status":"Suspended"});
// modJsList['tabTerminatedEmployee'] = new TerminatedEmployeeAdapter('Employee','TerminatedEmployee',{"status":"Suspended"});
modJsList['tabTerminatedEmployee'].setRemoteTable(true);
modJsList['tabTerminatedEmployee'].setShowAddNew(false);


<?php if (class_exists('\\Documents\\Admin\\Api\\DocumentsAdminManager')) {?>
modJsList['tabEmployeeDocument'] = new EmployeeDocumentAdapter('EmployeeDocument','EmployeeDocument');
modJsList['tabTerminatedEmployee'].setRemoteTable(true);
<?php } ?>

var modJs = modJsList['tabEmployee'];



</script>


<div class="modal" id="createUserModel" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><li class="fa fa-times"/></button>
                <h3 style="font-size: 17px;"><?=t('Employee Saved Successfully')?></h3>
            </div>
            <div class="modal-body">
				<?=t('Employee needs a User to login to this Hrm. Do you want to create a user for this employee now?')?> <br/><br/><?=t('You can do this later through Users module if required.')?>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" onclick="modJs.createUser();">Yes</button>
                <button class="btn" onclick="modJs.closeCreateUser();">No</button>
            </div>
        </div>
    </div>
</div>

<!-- STAFF SUSPENSION MODAL -->

<div class="modal" id="employeeSuspensionModel" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><li class="fa fa-times"/></button>
		<h3 style="font-size: 17px;"><?=t('Staff Suspension')?></h3>
	</div>
	<div class="modal-body">
		<form id="leaveStatusForm">
		<div class="control-group">
			<label class="control-label" for="suspension_status"><?=t('Reason for Suspension')?></label>
			<div class="controls">
			  	<textarea id="suspension_reason" class="form-control" name="suspension_reason" maxlength="500"></textarea>
			</div>
		</div>
		<div class="control-group">
							<label class="control-label" for="start_date"><?=$itemName?> <?=t('Start Date')?></label>
							<div class="controls">
							<input type="date" class="form-control" id="<?=$itemNameLower?>_start_date"  name ="<?=$itemNameLower?>_start_date">
							
							</div>
		</div>
		<div class="control-group">
							<!-- <label class="control-label" for="employee_id"><?=$itemName?> <?=t('ID')?></label> -->
							<div class="controls">
							<input type="text" class="form-control" id="<?=$itemNameLower?>_employee_id"  name ="<?=$itemNameLower?>_employee_id">
							
								
							</div>
		</div>
		<div class="control-group">
							<label class="control-label" for="end_date"><?=$itemName?> <?=t('End Date')?></label>
							<div class="controls">
							<input type="date" class="form-control" id="<?=$itemNameLower?>_end_date"  name ="<?=$itemNameLower?>_end_date">
							
								
							</div>
		</div>
		<!-- <div class="control-group">
			<label class="control-label" for="leave_status"><?=t('Salary')?></label>
			<div class="controls">
			  	<select type="text" id="leave_status" class="form-control" name="leave_status" value="">
				  	<option value="Approved">Full Pay</option>
				  	<option value="Pending">Half Pay</option>
				  	<option value="Rejected">No Pay</option>
				  
			  	</select>
			</div> 
		</div> -->
		
		<div class="control-group">
							<label class="control-label" for="employee_salary"><?=$itemName?> <?=t('Reduce Salary By(%):')?></label>
							<div class="controls">
							<input type="text" class="form-control" id="<?=$itemNameLower?>_employee_salary"  name ="<?=$itemNameLower?>_employee_salary">
							
								</select>
							</div>
		</div>
		
		</form>
	</div>
	<div class="modal-footer">
 		<button class="btn btn-primary" onclick="modJs.saveSuspension();"><?=t('Save')?></button>
 		<button class="btn" onclick="modJs.closeEmployeeSuspension();"><?=t('Cancel')?></button>
	</div>
</div> 
</div>
</div>


<!-- STAFF TERMINATION MODAL -->

<div class="modal" id="employeeTerminationModel" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><li class="fa fa-times"/></button>
		<h3 style="font-size: 17px;"><?=t('Staff Contract Termination')?></h3>
	</div>
	<div class="modal-body">
		<form id="staffTerminationForm">
		<div class="control-group">
			<label class="control-label" for="termination_reason"><?=t('Reason for Termination')?></label>
			<div class="controls">
			  	<select type="select" id="termination_reason" class="form-control" name="termination_reason" value="">
				  	<option value="Retiremant">Retiremant</option>
				  	<option value="Redundancy">Redundancy</option>
				  	<option value="Dismissal">Dismissal</option>
					<option value="Resignation">Resignation</option>
					<option value="Ill Health">Ill Health</option>
					<option value="Ill Health">Death</option>
				  
			  	</select>
			</div> 
		</div>
		<div class="control-group">
							<label class="control-label" for="date"><?=$itemName?> <?=t('Date of Termination')?></label>
							<div class="controls">
							<input type="date" class="form-control" id="<?=$itemNameLower?>_date"  name ="<?=$itemNameLower?>_date">
							
							</div>
		</div>
		<div class="control-group">
							<label class="control-label" for="details"><?=$itemName?> <?=t('Details')?></label>
							<div class="controls">
							<input type="textarea" class="form-control" id="<?=$itemNameLower?>details"  name ="<?=$itemNameLower?>details">
							
							</div>
		</div>
		<!-- <div class="control-group">
							<label class="control-label" for="_employee_id"><?=$itemName?> <?=t('ID')?></label>
							<div class="controls">
							<input type="text" class="form-control" id="<?=$itemNameLower?>_employee_id"  name ="<?=$itemNameLower?>_employee_id">
							
								
							</div>
		</div> -->	
		</form>
	</div>
	<div class="modal-footer">
 		<button class="btn btn-primary" onclick="modJs.saveTermination();"><?=t('Save')?></button>
 		<button class="btn" onclick="modJs.closeEmployeeTermination();"><?=t('Cancel')?></button>
	</div>
</div> 
</div>
</div>



<?php include APP_BASE_PATH.'footer.php';?>
