<?php
$moduleName = 'medical';
$moduleGroup = 'admin';
define('MODULE_PATH', dirname(__FILE__));
include APP_BASE_PATH . 'header.php';
include APP_BASE_PATH . 'modulejslibs.inc.php';
$user = \Classes\BaseService::getInstance()->getCurrentUser();
?><div class="span9">

	<ul class="nav nav-tabs" id="modTab" style="margin-bottom:0px;margin-left:5px;border-bottom: none;">
		<li class="active"><a id="tabEmployeeTransfer" href="#tabPageStaffMedical"><?= t('Employee Transfer') ?></a></li>
		<!-- <li class=""><a id="tabDependentMedical" href="#tabPageDependentMedical"><?= t('Dependents Medical') ?></a></li>
    <li class=""><a id="tabMedicalLimit" href="#tabPageMedicalLimit"><?= t('Medical Limits Setup') ?></a></li> -->
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="tabPageStaffMedical">
			<div id="EmployeeTransfer" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="EmployeeTransferForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
		<div class="tab-pane" id="tabPageDependentMedical">
			<div id="DependentMedical" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="DependentMedicalForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
		<div class="tab-pane" id="tabPageMedicalLimit">
			<div id="MedicalLimit" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="MedicalLimitForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
	</div>

</div>
<script>
	var modJsList = new Array();

	modJsList['tabEmployeeTransfer'] = new EmployeeTransferAdapter('EmployeeTransfer', 'EmployeeTransfer');
	modJsList['tabEmployeeTransfer'].setRemoteTable(true);
	// modJsList['tabDependentMedical'] = new DependentMedicalAdapter('DependentMedical', 'DependentMedical');
	// modJsList['tabDependentMedical'].setRemoteTable(true);
	// modJsList['tabMedicalLimit'] = new MedicalLimitAdapter('MedicalLimit', 'MedicalLimit');
	// modJsList['tabMedicalLimit'].setRemoteTable(true);

	var modJs = modJsList['tabEmployeeTransfer'];
</script>
<?php include APP_BASE_PATH . 'footer.php'; ?>