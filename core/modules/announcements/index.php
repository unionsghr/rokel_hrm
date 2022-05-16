<?php
/*
 Copyright (c) 2018 [Glacies UG, Berlin, Germany] (http://glacies.de)
 Developer: Thilina Hasantha (http://lk.linkedin.com/in/thilinah | https://github.com/thilinah)
 */

$moduleName = 'announcements';
$moduleGroup = 'modules';
define('MODULE_PATH', dirname(__FILE__));
include APP_BASE_PATH . 'header.php';
include APP_BASE_PATH . 'modulejslibs.inc.php';
?><div class="span9">
    <style type="text/css">
        .CodeMirror {
            height: 130px;
            min-height: 130px;
            max-height: 210px;
        }

        .CodeMirror-scroll {
            height: 120px;
            min-height: 120px;
            max-height: 200px;
        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <div id="Announcement" class="row">
                <?php if ($user->user_level === 'Admin' || (isset($modulePermissions['perm']['Post Announcements']) && $modulePermissions['perm']['Post Announcements'] === "Yes")) { ?>
                    <div class="col-md-12">
                        <div class="box-footer">
                            <form action="#" method="post">
                                <img class="img-responsive img-circle img-sm" src="<?= \Classes\UIManager::getInstance()->getCurrentProfile()->image ?>" alt="Alt Text">
                                <!-- .img-push is used to add margin to elements next to floating images -->
                                <div class="img-push">
                                    <textarea id="contentMessage" class="form-control input-sm chattext" placeholder="Type your message here" style="height: 120px;"></textarea>
                                    <label for="receipents">Select Department/Branch/Outlet :</label>
                                    <select id="receipents" class=" js-example-basic-multiple" name="states[]" multiple="multiple" style="width: 430px;">

                                    </select>
                                    <br><br>
                                    <label id="attachment" name="attachment" type="fileupload" class="control-label uploadInput" validation="none"><?= t('Attach File') ?></label>
                                    <span id="attachment_remove" onclick="$('#attachment').attr('val','');$('#attachment').html('');$('#attachment_download').hide();return false;" class="file-action-icon" style="margin-top:3px;display:none;"><i class="fa fa-remove text-red"></i></span>
                                    <span id="attachment_download" onclick="download($('#attachment').attr('val'));return false;" class="file-action-icon" style="display:none;"><i class="fa fa-cloud-download text-aqua"></i></span>
                                    <span id="attachment_upload" onclick="modJs.uploadPostAttachment();return false;" class="file-action-icon"><i class="fa fa-cloud-upload text-green"></i></span>
                                    <br>
                                    <br>
                                    <button id="savePost" class="btn btn-mini btn-default conversation-save-post" onclick="modJs.addConversation();return false;"><?= t('Publish Announcement') ?></button>

                                </div>
                            </form>
                        </div>
                    </div>
                <?php } ?>
                <div class="col-md-12 objectList">

                </div>
                <div class="col-md-4 col-sm-10 col-md-offset-4 col-sm-offset-1">
                    <button id="loadMore" class="btn btn-mini btn-default" style="width:100%;display:none;"><?= t('Load More') ?></button>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
    var modJsList = [];
    modJsList['tabConversation'] = new AnnouncementsAdapter('Conversation', 'Announcement');

    var modJs = modJsList['tabConversation'];
    modJsList['tabConversation'].setLoadMoreButton($("#loadMore"));
    modJsList['tabConversation'].setSearchBox($("#search"));
    modJsList['tabConversation'].setConversationType('Announcement');
    modJsList['tabConversation'].setPageSize(10);

    <?php if ($user->user_level === 'Admin' || (isset($modulePermissions['perm']['Post Announcements']) && $modulePermissions['perm']['Post Announcements'] === "Yes")) { ?>

        var element = $('#contentMessage');
        var simplemde = new SimpleMDE({
            element: element[0],
            toolbar: ["bold", "italic", "heading", "|", "quote", "guide"]
        });
        element.data('simplemde', simplemde);

        //when document is done loading carry out this activity
        document.addEventListener("DOMContentLoaded", function(event) {
            var receipents = document.getElementById('receipents');
            // receipents.select2();
            // console.log(receipents);
            //post data for new notch values
            $.ajax({
                url: "../../../../rokel_hrm/core/getReceipents.php",
                type: "post",
                contentType: "application/json",
                dataType: "json",
                // data: JSON.stringify({
                //     paygrade_id: 1,
                // }),
                success: function(data, textStatus, jQxhr) {

                    //get the response data
                    var dept = data;

                    //get the department values
                    var departments = dept.data;

                    //for each notch value append to the notch select element
                    departments.forEach(departmentFunction);

                    function departmentFunction(item, index) {

                        //create option tag, add the notch name and value the 
                        //append to the notch select
                        var option = document.createElement("option");
                        option.text = item[1];
                        option.value = item[0];
                        receipents.appendChild(option);
                    }

                },
            });
        });


        function addConversation1() {
            event.preventDefault();
            // var rec = document.getElementById('receipents');
            console.log($('#receipents').select2('data'));
        }


    <?php } ?>
</script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
</script>
<?php include APP_BASE_PATH . 'footer.php'; ?>