</section><!-- /.content -->
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
		<script type="text/javascript">

		
		
		for (var prop in modJsList) {
			if(modJsList.hasOwnProperty(prop)){
				modJsList[prop].setPermissions(<?=json_encode($modulePermissions['perm'])?>);
				modJsList[prop].setFieldTemplates(<?=json_encode($fieldTemplates)?>);
				modJsList[prop].setTemplates(<?=json_encode($templates)?>);
				modJsList[prop].setCustomTemplates(<?=json_encode($customTemplates)?>);
				<?php if(isset($emailTemplates)){?>
				modJsList[prop].setEmailTemplates(<?=json_encode($emailTemplates)?>);
				<?php } ?>
				modJsList[prop].setUser(<?=json_encode($user)?>);
                <?php if(isset($_REQUEST['action']) && $_REQUEST['action'] == "new"){?>
                if(modJsList[prop].newInitObject == undefined || modJsList[prop].newInitObject == null){
                    modJsList[prop].initFieldMasterData(null,modJsList[prop].renderForm);
                }else{
                    modJsList[prop].initFieldMasterData(null,modJsList[prop].renderForm, modJsList[prop].newInitObject);
                }
                <?php }else{?>
                modJsList[prop].initFieldMasterData(null, modJs.loadingFunction);
                <?php }?>
				modJsList[prop].setBaseUrl('<?=BASE_URL?>');
				modJsList[prop].setCurrentProfile(<?=json_encode($activeProfile)?>);
				modJsList[prop].setInstanceId('<?=$baseService->getInstanceId()?>');
				modJsList[prop].setNoJSONRequests('<?=$noJSONRequests?>');
			}
	    }

		var clientUrl = '<?=CLIENT_BASE_URL?>';
		
	</script>
	<?php include 'popups.php';?>
    <script src="<?=BASE_URL?>js/bootstrap-datatable.js"></script>
    </body>
</html>
