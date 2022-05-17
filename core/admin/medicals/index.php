<?php
$moduleName = 'medical';
$moduleGroup = 'admin';
define('MODULE_PATH', dirname(__FILE__));
include APP_BASE_PATH . 'header.php';
include APP_BASE_PATH . 'modulejslibs.inc.php';
$user = \Classes\BaseService::getInstance()->getCurrentUser();
?><div class="span9">

	<ul class="nav nav-tabs" id="modTab" style="margin-bottom:0px;margin-left:5px;border-bottom: none;">
		<li class="active"><a id="tabStaffMedical" href="#tabPageStaffMedical"><?= t('Staff Medical') ?></a></li>
		<li class=""><a id="tabDependentMedical" href="#tabPageDependentMedical"><?= t('Dependents Medical') ?></a></li>
		<li class=""><a id="tabMedicalLimit" href="#tabPageMedicalLimit"><?= t('Medical Limits Setup') ?></a></li>
		<li class=""><a id="tabWorkInjuries" href="#tabPageWorkInjuries"><?= t(' Injuries') ?></a></li>
		<li class=""><a id="tabMedEnquiry" href="#tabPageMedEnquiry"><?= t('Staff Medical Enquiry') ?></a></li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active" id="tabPageStaffMedical">
			<div id="StaffMedical" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="StaffMedicalForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

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
		<div class="tab-pane" id="tabPageWorkInjuries">
			<div id="WorkInjuries" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="WorkInjuriesForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
		<div class="tab-pane" id="tabPageMedEnquiry">
			<div id="MedEnquiry" class="reviewBlock" data-content="List" style="padding-left:5px;">

			</div>
			<div id="MedEnquiryForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

			</div>
		</div>
	</div>

</div>
<script>
	var modJsList = new Array();

	modJsList['tabStaffMedical'] = new StaffMedicalAdapter('StaffMedical', 'StaffMedical');
	modJsList['tabStaffMedical'].setRemoteTable(true);
	modJsList['tabDependentMedical'] = new DependentMedicalAdapter('DependentMedical', 'DependentMedical');
	modJsList['tabDependentMedical'].setRemoteTable(true);
	modJsList['tabMedicalLimit'] = new MedicalLimitAdapter('MedicalLimit', 'MedicalLimit');
	modJsList['tabMedicalLimit'].setRemoteTable(true);
	modJsList['tabWorkInjuries'] = new WorkInjuriesAdapter('WorkInjuries', 'WorkInjuries');
	modJsList['tabWorkInjuries'].setRemoteTable(true);
	modJsList['tabMedEnquiry'] = new MedEnquiryAdapter('MedEnquiry', 'MedEnquiry');
	modJsList['tabMedEnquiry'].setRemoteTable(true);

	var modJs = modJsList['tabStaffMedical'];
</script>
<!-- <script>
	$(document).ready(function() {
		const list = document.getElementsByTagName("td");
		console.log(list.innerHTML);
		// alert("here....")
	});
</script> -->
<?php include APP_BASE_PATH . 'footer.php'; ?>