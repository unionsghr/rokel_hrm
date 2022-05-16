<?php
/*
 Copyright (c) 2018 [Glacies UG, Berlin, Germany] (http://glacies.de)
 Developer: Thilina Hasantha (http://lk.linkedin.com/in/thilinah | https://github.com/thilinah)
 */

$moduleName = 'conversations';
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <div class="row">

        <div class="col-md-12">
            <div id="Conversation" class="row">
                <div class="col-md-12">
                    <div class="box-footer">
                        <form action="#" method="post">
                            <img class="img-responsive img-circle img-sm" src="<?= \Classes\UIManager::getInstance()->getCurrentProfile()->image ?>" alt="Alt Text">
                            <!-- .img-push is used to add margin to elements next to floating images -->
                            <div class="img-push">
                                <textarea id="contentMessage" class="col-md-11 col-sm-10 chat-message" placeholder="Type your message here"></textarea>
                                <br><br><br>
                                <!-- <label for="receipents">Select Employee </label> -->
                                <select id="receipents" name="employee" style="width: 430px;height: 30px" required>
                                    <center>
                                        <option value="">
                                            SELECT EMPLOYEE

                                        </option>
                                    </center>
                                </select>
                                <br>
                                <label id="attachment" name="attachment" type="fileupload" class="control-label uploadInput" validation="none"><?= t('Attach File') ?></label>
                                <span id="attachment_remove" onclick="$('#attachment').attr('val','');$('#attachment').html('');$('#attachment_download').hide();return false;" class="file-action-icon" style="margin-top:3px;display:none;"><i class="fa fa-remove text-red"></i></span>
                                <span id="attachment_download" onclick="download($('#attachment').attr('val'));return false;" class="file-action-icon" style="display:none;"><i class="fa fa-cloud-download text-aqua"></i></span>
                                <!-- <span id="attachment_upload" onclick="modJs.uploadPostAttachment();return false;" class="file-action-icon"><i class="fa fa-cloud-upload text-green"></i></span> -->
                                <span id="attachment_upload" onclick="modJs.uploadPostAttachment();return false;" class="file-action-icon"><i class="fa fa-cloud-upload text-green"></i></span>
                                <br>
                                <button id="savePost" class="btn btn-mini btn-default conversation-save-post" onclick="modJs.addConversation();return false;"><?= t('Send') ?></button>
                                <img id="conversationLoader" style="display:none;margin-bottom: 15px;" src="<?= BASE_URL ?>images/small-loader.gif" />

                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-12 objectList">

                </div>
                <div>

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
    modJsList['tabConversation'] = new ChatAdapter('Conversation', 'Conversation');

    var modJs = modJsList['tabConversation'];
    modJsList['tabConversation'].setLoadMoreButton($("#loadMore"));
    modJsList['tabConversation'].setSearchBox($("#search"));
    modJsList['tabConversation'].setConversationType('Message');
    modJsList['tabConversation'].setPageSize(15);

    $(document).ready(function() {
        $('.chat-message')
            .on('focus.autoExpand', function() {
                var savedValue = this.value;
                this.value = '';
                this.baseScrollHeight = this.scrollHeight;
                this.value = savedValue;
            })
            .on('input.autoExpand', function() {
                var minRows = this.getAttribute('data-min-rows') | 0,
                    rows;
                this.rows = minRows;
                rows = Math.ceil((this.scrollHeight - this.baseScrollHeight) / 16);
                this.rows = minRows + rows;
            });



        var receipents = document.getElementById('receipents');
        // receipents.select2();
        // console.log(receipents);
        //post data for new notch values
        $.ajax({
            url: "../../../../rokel_hrm/core/getEmployees.php",
            type: "post",
            contentType: "application/json",
            dataType: "json",
            // data: JSON.stringify({
            //     paygrade_id: 1,
            // }),
            success: function(data, textStatus, jQxhr) {

                //get the response data
                var users_data = data;

                //get the department values
                var users = users_data.data;

                //for each notch value append to the notch select element
                users.forEach(departmentFunction);

                function departmentFunction(item, index) {

                    //create option tag, add the notch name and value the 
                    //append to the notch select
                    var option = document.createElement("option");
                    option.text = item[1] + " " + item[2];
                    option.value = item[0];
                    receipents.appendChild(option);
                }

            },
        });
    })
</script>
<?php include APP_BASE_PATH . 'footer.php'; ?>