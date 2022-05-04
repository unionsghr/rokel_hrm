<div class="row">

    <div class="col-md-1 col-xs-0"></div>
    <div class="col-md-7 col-xs-12">
        <div class="reviewBlock" role="navigation" style="margin-top:10px;padding-top:10px;">
            <div class="row">
                <div class="col-md-12">
                    <img src="<?=$logoFileUrl?>" style="max-height:60px;margin-left:10px;float-left;"/>
                    <h3 style="margin-left:10px;float:right;"><?=empty($job->companyName)?$companyName:$job->companyName?></h3>
                </div>
            </div>
        </div>
        <div id="Job Details" class="reviewBlock entry" data-content="List" style="padding-left:5px;padding-top:10px;margin-top:10px;">
            <section class="job-content-header">
                <h1>
                    <?=$job->title?> <small><?=$enrichedJob->$countryName?></small>
                    <?php if (!empty($job->location)) {?>
                        <small>, <?=$job->location?></small>
                    <?php } ?>
                    <?php if (!empty($job->postalCode)) {?>
                        <small>, <?=$job->postalCode?></small>
                    <?php } ?>
                </h1>
            </section>
            <?php if($job->display != "Text Only"){?>
                <section class="job-content-description">
                    <img src="<?=$job->attachment?>" style="margin-left:120px;"/>
                </section>
            <?php }?>
            
            <?php if($job->display == "Text Only" || $job->display == "Image and Full Text"){?>
                <section class="job-content-description">
                    <?=nl2br($job->description)?>
                </section>
                <?php if(!empty($job->shortDescription)){?>
                    <section class="job-content-header">
                        <h2>Short Description</h2>
                    </section>
                    <section class="job-content-description">
                        <?=nl2br($job->shortDescription)?>
                    </section>
                <?php }?>
                <?php if(!empty($job->requirements)){?>
                    <section class="job-content-header">
                        <h2>Requirements</h2>
                    </section>
                    <section class="job-content-description">
                        <?=nl2br($job->requirements)?>
                    </section>
                <?php }?>                
                <?php if(!empty($benifits)){?>
                    <section class="job-content-header">
                        <h2>Benefits</h2>
                    </section>
                    <section class="job-content-description">
                        <?php foreach($benifits as $benifit){?>
                            <span class="label label-primary"><?=$benifit?></span>&nbsp;&nbsp;&nbsp;
                        <?php }?>
                    </section>
                <?php }?> 
                <?php if(!empty($job->closingDate)){?>
                    <section class="job-content-header">
                        <h2>Closing Date</h2>
                    </section>
                    <section class="job-content-description">
                    <?=nl2br($job->closingDate)?>
                    </section>
                <?php }?>     
                
            <?php }?>

           
            <?php if($job->display == "Image and Other Details"){?>
                <section class="job-content-header">
                    <h2>Other Details</h2>
                </section>
                <?php if(!empty($job->industry)){?>
                    <section class="job-content-description">
                        <div class="col-md-4"><b>Industry</b></div>
                        <div class="col-md-8">: <?=$enrichedJob->$industryName?></div>
                    </section>
                <?php }?>
                <?php if(!empty($job->employementType)){?>
                    <section class="job-content-description">
                        <div class="col-md-4"><b>Employement Type</b></div>
                        <div class="col-md-8">: <?=$enrichedJob->$employementTypeName?></div>
                    </section>
                <?php }?>
                <?php if(!empty($job->experienceLevel)){?>
                    <section class="job-content-description">
                        <div class="col-md-4"><b>Experience Level</b></div>
                        <div class="col-md-8">: <?=$enrichedJob->$experienceLevelName?></div>
                    </section>
                <?php }?>
                <?php if(!empty($job->jobFunction)){?>
                    <section class="job-content-description">
                        <div class="col-md-4"><b>Job Function</b></div>
                        <div class="col-md-8">: <?=$enrichedJob->$jobFunctionName?></div>
                    </section>
                <?php }?>
                <?php if(!empty($job->educationLevel)){?>
                    <section class="job-content-description">
                        <div class="col-md-4"><b>Education Level</b></div>
                        <div class="col-md-8">: <?=$enrichedJob->$educationLevelName?></div>
                    </section>
                <?php }?>
                 <?php if($job->showSalary == "Yes"){?>
                    <section class="job-content-description">
                        <div class="col-md-4"><b>Salary</b></div>
                        <div class="col-md-8">: <?=money_format("%!n", $job->salaryMin)?> <?=$currency->code?> - <?=money_format("%!n", $job->salaryMax)?> <?=$currency->code?></div>
                    </section>
                <?php }?>
                <?php if(!empty($job->closingDate) && $job->closingDate != "0000-00-00 00:00:00"){?>
                    <section class="job-content-description">
                        <div class="col-md-4"><b>Closing Date</b></div>
                        <div class="col-md-8">: <?=date('F j, Y',strtotime($job->closingDate))?></div>
                    </section>
                <?php }?>
            <?php }?>
            <div class="row">
                <div class="col-md-12">
                    <br/>
                </div>
            </div>
        </div>

    </div>
    <div class="col-md-3 col-xs-12" style="padding-top:10px;">
        <?php if(!empty($hiringManager)) {?>
        <div class="reviewBlock" data-content="Form" style="padding-left:5px;padding-top: 0px;">

            <div class="user-panel">
                <div class="row">
                    <div class="col-md-3 image">
                        <img src="<?=$hiringManager->image?>" class="img-circle recruiter-image" alt="User Image">
                    </div>
                    <div class="col-md-9">
                        <h3><?=$hiringManager->first_name?> <?=$hiringManager->middle_name?> <?=$hiringManager->last_name?></h3>
                        <p style="">Please fill your details bellow and apply. I'll get in touch once you are short listed</p>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <div id="CandidateForm" class="reviewBlock" data-content="Form" style="padding-left:5px;padding-top: 0px;display:none;">

        </div>

    </div>
    <div class="col-md-1 col-xs-0"></div>
</div>
<div class="row">
    <script>
        var modJsList = [];
        modJsList['tabCandidate'] = new CandidateAdapter('Candidate');
        modJsList['tabCandidate'].setRemoteTable(true);
        //modJsList['tabCandidate'].setShowFormOnPopup (true);
        modJsList['tabCandidate'].setJobCode('<?=$_GET['ref']?>');
        modJsList['tabCandidate'].setIsJobApplication(true);
        var modJs = modJsList['tabCandidate'];

        $(document).ready(function () {
            modJs.showQuickForm();
          $('#cv_title').val('<?=$job->title?>');
          $('.help-info').remove();
          $('.help_error_message').remove();

        }); 

    </script>
