<!-- Delete Modal -->
<div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<li class="fa fa-times" />
				</button>
				<h3 id="deleteModelLabel" style="font-size: 17px;"></h3>
			</div>
			<div class="modal-body">
				<p id="deleteModelBody"></p>
			</div>
			<div class="modal-footer">
				<button class="btn" onclick="modJs.cancelDelete();">Cancel</button>
				<button class="btn btn-primary" onclick="modJs.confirmDelete();">Delete</button>
			</div>
		</div>
	</div>
</div>
<!-- Delete Modal -->

<!-- Message Modal -->
<div class="modal fade" id="messageModel" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<li class="fa fa-times" />
				</button>
				<h3 id="messageModelLabel" style="font-size: 17px;"></h3>
			</div>
			<div class="modal-body">
				<p id="messageModelBody"></p>
			</div>
			<div class="modal-footer">
				<button class="btn" onclick="modJs.closeMessage();">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- Message Modal -->

<!-- Plain Message Modal -->
<div class="modal fade" id="plainMessageModel" tabindex="-1" role="dialog" aria-labelledby="plainMessageModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="border-bottom:none;/*background-color: #003C5F;*/">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-top:-10px;">
					<li class="fa fa-times" />
				</button>
			</div>
			<div class="modal-body">
				<p id="plainMessageModelBody"></p>
			</div>
		</div>
	</div>
</div>
<!-- Plain Message Modal -->

<!-- Data Message Modal -->
<div class="modal fade" id="dataMessageModel" tabindex="-1" role="dialog" aria-labelledby="dataMessageModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header" style="border-bottom:none;/*background-color: #003C5F;*/">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-top:-10px;">
					<li class="fa fa-times" />
				</button>
			</div>
			<div class="modal-body">
				<p id="dataMessageModelBody"></p>
			</div>
		</div>
	</div>
</div>
<!-- Data Message Modal -->

<!-- Yes No Modal -->
<div class="modal fade" id="yesnoModel" tabindex="-1" role="dialog" aria-labelledby="yesnoModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<li class="fa fa-times" />
				</button>
				<h3 id="yesnoModelLabel" style="font-size: 17px;"></h3>
			</div>
			<div class="modal-body">
				<p id="yesnoModelBody"></p>
			</div>
			<div class="modal-footer">
				<button id="yesnoModelNoBtn" class="btn" onclick="modJs.cancelYesno();">No</button>
				<button id="yesnoModelYesBtn" class="btn btn-primary">Yes</button>
			</div>
		</div>
	</div>
</div>
<!-- Yes No Modal -->

<!-- Upload Modal -->
<div class="modal fade" id="uploadModel" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<li class="fa fa-times" />
				</button>
				<h3 id="uploadModelLabel" style="font-size: 17px;"></h3>
			</div>
			<div class="modal-body">
				<p id="uploadModelBody"></p>
			</div>
			<div class="modal-footer">
				<button class="btn" onclick="$('#uploadModel').modal('hide');">Cancel</button>
			</div>
		</div>
	</div>
</div>
<!-- Upload Modal -->

<!-- Message Modal -->
<!-- <div class="modal fade" id="verifyModel" tabindex="-1" role="dialog" aria-labelledby="verifyModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><li class="fa fa-times"/></button>
				<h3 id="verifyModelLabel" style="font-size: 17px;"></h3>
			</div>
			<div class="modal-body">
				<p id="verifyModelBody">
					<b>Step 1:</b><br/>
					Please get your Instance Key from here:<br/>
					<a target="_blank" href="<?= APP_WEB_URL ?>/generateInstanceKey.php?id=<?= $baseService->getInstanceId() ?>">
						<?= APP_WEB_URL ?>/generateInstanceKey.php?id=<?= $baseService->getInstanceId() ?>
					</a>

					<br/><b>Step 2:</b><br/>
					Enter the key you generated in step 1 here and click "Verify"<br/>
				<form role="form">
					<div class="row">
						<label class="col-sm-12 control-label" for="verificationKey">Verification Key</label>
						<div class="controls col-sm-12">
							<input class="form-control" type="text" id="verificationKey" name="verificationKey" value=""/>
						</div>
					</div>
					<br/><br/>
					<div class="control-group row">
						<div class="controls col-sm-12">
							<button onclick="try{verifyInstance($('#verificationKey').val());}catch(e){};return false;" class="saveBtn btn btn-primary pull-right"><i class="fa fa-save"></i> Verify</button>
							<button onclick="$('#verifyModel').modal('hide');return false;" class="cancelBtn btn pull-right" style="margin-right:5px;"><i class="fa fa-times-circle-o"></i> Cancel</button>
						</div>
						<div class="controls col-sm-3">
						</div>
					</div>
			</div>
			</form>
			</p>
		</div>
	</div>
</div> -->
</div>
<!-- Message Modal -->


<?php if ($user->user_level == 'Admin') { ?>
	<!-- Modal -->
	<div class="modal fade" id="profileSwitchModal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<li class="fa fa-times" />
					</button>
					<h3 id="myModalLabel"><?= t('Switch Employee') ?></h3>
				</div>
				<div class="modal-body">
					<p><?= t('Select The Employee to Switch Into') ?></p>
					<div style="border: solid 1px #EEE;">
						<select id="switch_emp" style="width:100%;">

							<?php
							$employees = $baseService->get('Employee');
							foreach ($employees as $empTemp) {
							?>
								<option value="<?= $empTemp->id ?>"><?= $empTemp->first_name . " " . $empTemp->middle_name . " " . $empTemp->last_name ?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn" data-dismiss="modal" aria-hidden="true"><?= t('Close') ?></button>
					<button class="btn btn-primary" onclick="modJs.setAdminProfile($('#switch_emp').val());return false;"><?= t('Switch') ?></button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal -->
<?php } ?>

<!-- EXPENSE MODAL -->
<?php if (isset($itemNameLower)) { ?>
	<div class="modal" id="<?= $itemNameLower ?>StatusModel" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<li class="fa fa-times" />
					</button>
					<h3 style="font-size: 17px;">Change <?= $itemName ?> Status</h3>
				</div>
				<div class="modal-body">
					<form id="expenseStatusForm">
						<div class="control-group">
							<label class="control-label" for="expense_status"><?= $itemName ?> Status</label>
							<div class="controls">
								<select type="text" id="<?= $itemNameLower ?>_status" class="form-control" name="<?= $itemNameLower ?>_status" value="">

								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="employee_id"> </label>
							<div class="controls">
								<input type="hidden" class="form-control" id="<?= $itemNameLower ?>_employee_Id" name="<?= $itemNameLower ?>_employee_Id">

							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="expense_status">Note</label>
							<div class="controls">
								<textarea id="<?= $itemNameLower ?>_reason" class="form-control" name="<?= $itemNameLower ?>_reason" maxlength="500"></textarea>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" onclick="modJs.changeStatus();">Change <?= $itemName ?> Status</button>
					<button class="btn" onclick="modJs.closeDialog();">Not Now</button>
				</div>
			</div>
		</div>
	</div>
<?php } ?>


<!-- IMPREST MODAL -->
<?php if (isset($itemNameLower)) { ?>
	<div class="modal" id="<?= $itemNameLower ?>StatusModal" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
						<li class="fa fa-times" />
					</button>
					<h3 style="font-size: 17px;">Change Request Status</h3>
				</div>
				<div class="modal-body">
					<form id="expenseStatusForm">
						<div class="control-group">
							<label class="control-label" for="expense_status"> Change Status</label>
							<div class="controls">
								<select type="text" id="<?= $itemNameLower ?>status" class="form-control" name="<?= $itemNameLower ?>_status" value="">

								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="employee_id"></label>
							<div class="controls">
								<input type="hidden" class="form-control" id="<?= $itemNameLower ?>_emp_Id" name="<?= $itemNameLower ?>_emp_Id">

								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label" for="expense_status">Note</label>
							<div class="controls">
								<textarea id="<?= $itemNameLower ?>_reason" class="form-control" name="<?= $itemNameLower ?>_reason" maxlength="500"></textarea>
							</div>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button class="btn btn-primary" onclick="modJs.changeStatus();">Change Status</button>
					<button class="btn" onclick="modJs.closeDialog();">Not Now</button>
				</div>
			</div>
		</div>
	</div>
<?php } ?>

<!-- Payroll Summary Modal End-->
<div class="modal fade" id="payroll_summary" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<li class="fa fa-times" />
				</button>
				<h3 id="payrollModelHead" style="font-size: 22px; text-align: center;">Payroll Summary Report</h3>
			</div>
			<div class="modal-body">
				<div id="payrollModelBody"></div>
			</div>
			<div class="control-group">
				<!-- <label class="control-label" for="employee_id"> ID</label> -->
				<div class="controls">
					<input type="hidden" class="form-control" id="employee_Id" name="employee_Id">

					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn" onclick="modJs.closeDialog();">Cancel</button>
				<button id="approvePayroll" class="btn btn-success" onclick="modJs.approve();return false;">Verify<i class="fa fa-check"></i></button>
				<button id="rejectPayroll" class="btn btn-small btn-warning" onclick="modJs.reject();">Reject <i class="fa fa-times"></i></button>
			</div>
		</div>
	</div>
</div>

<!-- Payroll Summary Modal End -->

<!-- Staff Medicals Modal -->
<div class="modal fade" id="staffmedical" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<li class="fa fa-times" />
				</button>
				<h3 id="medicalModelHead" style="font-size: 22px; text-align: center;">Medical Expense</h3>
			</div>
			<div class="modal-body">
				<div id="medicalModelBody"></div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-small" onclick="modJs.download();">View Attachment</button>
				<button class="btn" onclick="modJs.closeDialog();">Cancel</button>
				<button class="btn btn-success" onclick="modJs.submitStaff();return false;"></i>Submit</button>
				<button class="btn btn-success" onclick="modJs.approve();return false;">Approve <i class="fa fa-check"></i></button>
				<button class="btn btn-small btn-warning" onclick="modJs.reject();"> Reject <i class="fa fa-times "></i></button>
			</div>
		</div>
	</div>
</div>
<!-- Staff Medicals Modal -->


<!--Approved Staff Medicals Modal -->
<div class="modal fade" id="appstaffmedical" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<li class="fa fa-times" />
				</button>
				<h3 id="medicalModelHead" style="font-size: 22px; text-align: center;">Medical Expense</h3>
			</div>
			<div class="modal-body">
				<div id="medicalModelBody1"></div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-small" onclick="modJs.download();">View Attachment</button>
				<button class="btn" onclick="modJs.closeDialog();">Cancel</button>
				<!-- <button class="btn btn-success" onclick="modJs.submitStaff();return false;"></i>Submit</button> -->
				<!-- <button class="btn btn-success" onclick="modJs.approve();return false;">Approve <i class="fa fa-check"></i></button> -->
				<!-- <button class="btn btn-small btn-warning" onclick="modJs.reject();"> Reject <i class="fa fa-times "></i></button> -->
			</div>
		</div>
	</div>
</div>
<!--Approved Staff Medicals Modal -->

<!--Submiited Staff Medicals Modal -->
<div class="modal fade" id="submittedstaffmedical" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<li class="fa fa-times" />
				</button>
				<h3 id="medicalModelHead" style="font-size: 22px; text-align: center;">Medical Expense</h3>
			</div>
			<div class="modal-body">
				<div id="medicalModelBodySubmitted"></div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-small" onclick="modJs.download();">View Attachment</button>
				<button class="btn" onclick="modJs.closeDialog();">Cancel</button>
				<!-- <button class="btn btn-success" onclick="modJs.submitStaff();return false;"></i>Submit</button> -->
				<button class="btn btn-success" onclick="modJs.approve();return false;">Approve <i class="fa fa-check"></i></button>
				<button class="btn btn-small btn-warning" onclick="modJs.reject();"> Reject <i class="fa fa-times "></i></button>
			</div>
		</div>
	</div>
</div>
<!--Submitted Staff Medicals Modal -->




<!-- Dependent Medicals Modal -->
<div class="modal fade" id="dependentmedical" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<li class="fa fa-times" />
				</button>
				<h3 id="medicalModelHead" style="font-size: 22px; text-align: center;">Medical Expense</h3>
			</div>
			<div class="modal-body">
				<div id="dependentModelBody"></div>
			</div>
			<div class="modal-footer">
				<button class="btn" onclick="modJs.closeDialog();">Cancel</button>
				<button class="btn btn-success" onclick="modJs.submitDependent();return false;">Submit</button>
				<button class="btn btn-success" onclick="modJs.approveDependent();return false;">Approve <i class="fa fa-check"></i></button>
				<button class="btn btn-small btn-warning" onclick="modJs.rejectDependent();"> Reject <i class="fa fa-times "></i></button>
			</div>
		</div>
	</div>
</div>
<!-- Dependent Medicals Modal  -->

<!-- Medical Limits Modal -->
<div class="modal fade" id="medicalLimits" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					<li class="fa fa-times" />
				</button>
				<h3 id="medicalModelHead" style="font-size: 22px; text-align: center;">Medical Expense Limit</h3>
			</div>
			<div class="modal-body">
				<div id="limitModelBody"></div>
			</div>
			<div class="modal-footer">
				<button class="btn" onclick="modJs.closeDialog();">Cancel</button>
				<button class="btn btn-success" onclick="modJs.approveLimit();return false;"><i class="fa fa-check"></i>Approve/Verify</button>
				<button class="btn btn-small btn-warning" onclick="modJs.rejectLimit();"> Reject <i class="fa fa-times "></i></button>
			</div>
		</div>
	</div>
</div>
<!-- Medical Limits Modal  -->

<!-- Certification Modal -->
<div class="modal fade modal-lg" id="certification" tabindex="-1" role="dialog" aria-labelledby="messageModelLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<!-- <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><li class="fa fa-times"/></button>
				<h3 id="certificateModelHead" style="font-size: 22px; text-align: center;">Certificate</h3>
			</div> -->
			<div class="modal-body " id="certificateModelBody" style="margin-left: -50% !important">
				<div id="certificateModelBody" style="margin-left: -45% !important"></div>
			</div>

			<!-- <div class="modal-footer">
				<button class="btn" onclick="modJs.closeDialog();">Cancel</button>
				<button class="btn btn-success" onclick="modJs.approve();return false;">Download <i class="fa fa-check"></i></button>
				<button class="btn btn-small btn-warning" onclick="modJs.reject();">Send Via Email <i class="fa fa-times"></i></button>
			</div> -->
		</div>
	</div>
</div>
<!-- Certification Modal -->
<script>
	let id = _id_;
	// var medical_summary;

	$.ajax({
				url: "../../../../rokel_hrm/core/payrollStatus.php",
				type: "post",
				contentType: "application/json",
				dataType: "json",
				data: JSON.stringify({
					id_: id,
					// status_:status
					// category: category
				}),
				success: function(data, textStatus, jQxhr) {
					// console.log(data);
					// alert(data);
					if (data.responseCode == "000") {
						// alert("here"); return false;

						let status = data.data;
						// let posted_by = data.data1;
						// let currentProfile = data.data2;
						// alert(posted_by); 
						// alert(currentProfile);
						// alert(JSON.stringify(medical_summary)); return false
						var app_status = 'Approved';

						if (app_status == "Approved" || app_status == "Rejected") {
							document.getElementById("approvePayroll").style.visibility =
								"hidden";
							document.getElementById("rejectPayroll").style.visibility =
								"hidden";
						} else if (app_status == "Rejected") {
							document.getElementById("approvePayroll").style.visibility =
								"hidden";
							document.getElementById("rejectPayroll").style.visibility =
								"hidden";

							// } else if (app_status == "Processing") {
							//   document.getElementById("employeeSuspension").style.visibility =
							//     "hidden";
							// }
						} else {
							alert("Unsuccessful");
						}
					},
				});
</script>