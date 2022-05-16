<?php

$moduleName = 'payroll';
$moduleGroup = 'admin';
define('MODULE_PATH', dirname(__FILE__));
include APP_BASE_PATH . 'header.php';
include APP_BASE_PATH . 'modulejslibs.inc.php';
?><script type="text/javascript" src="<?= BASE_URL ?>js/mindmup-editabletable.js?v=<?= $jsVersion ?>"></script>
<style type="text/css">
    .sorting_disabled {
        min-width: 80px;
    }
</style>
<div class="span9">
    <ul class="nav nav-tabs" id="modTab" style="margin-bottom:0px;margin-left:5px;border-bottom: none;">
        <li class="active"><a id="tabPayrollEmployee" href="#tabPagePayrollEmployee"><?= t('Payroll Employees') ?></a></li>
        <li class=""><a id="tabPayroll" href="#tabPagePayroll"><?= t('Payroll Reports') ?></a></li>
        <li class=""><a id="tabPayrollColumn" href="#tabPagePayrollColumn"><?= t('Payroll Columns') ?></a></li>
        <li class=""><a id="tabDeductionGroup" href="#tabPageDeductionGroup"><?= t('Calculation Groups') ?></a></li>
        <li class=""><a id="tabDeduction" href="#tabPageDeduction"><?= t('Saved Calculations') ?></a></li>
        <li class=""><a id="tabPayslipTemplate" href="#tabPagePayslipTemplate"><?= t('Payslip Templates') ?></a></li>

    </ul>

    <div class="tab-content">
        <div class="tab-pane active" id="tabPagePayrollEmployee">
            <div id="PayrollEmployee" class="reviewBlock" data-content="List" style="padding-left:5px;">

            </div>
            <div id="PayrollEmployeeForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

            </div>
        </div>

        <div class="tab-pane " id="tabPagePayroll">
            <div id="Payroll" class="reviewBlock" data-content="List" style="padding-left:5px;">

            </div>
            <div id="PayrollForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

            </div>
            <div id="PayrollData" class="reviewBlock" data-content="List" style="padding-left:5px;display:none;overflow-x: auto;">

            </div>
            <div id="PayrollDataButtons" style="text-align: right;margin-top: 10px;">
                <button class="cancelBtnTable btn" style="margin-right:5px;"><i class="fa fa-times-circle-o"></i> Cancel</button>
                <button class="saveBtnTable btn btn-primary" style="margin-right:5px;"><i class="fa fa-save"></i> Save</button>
                <button class="downloadBtnTable btn btn-primary" style="margin-right:5px;"><i class="fa fa-check"></i> Download</button>
                <button class="downloadBtnTableExcel btn btn-primary" style="margin-right:5px;"><i class="fa fa-check"></i> Download (Excel)</button>
                <button class="downloadBtnTablePdf btn btn-primary" style="margin-right:5px;"><i class="fa fa-check"></i> Download (Pdf)</button>
                <!-- <button class="verifyBtnTable btn btn-primary" style="margin-right:5px;"><i class="fa fa-check"></i> Verify</button> -->
                <form method="POST" action="bulk_api.php"><input type="hidden" id="payroll_id_" name="payroll_id_"><button type="submit" class="completeBtnTable btn btn-primary" style="margin-right:5px;"><i class="fa fa-check-square-o"></i> Finalize</button></form>

            </div>

        </div>

        <div class="tab-pane" id="tabPagePayrollColumn">
            <div id="PayrollColumn" class="reviewBlock" data-content="List" style="padding-left:5px;">

            </div>
            <div id="PayrollColumnForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

            </div>
        </div>

        <div class="tab-pane" id="tabPageDeductionGroup">
            <div id="DeductionGroup" class="reviewBlock" data-content="List" style="padding-left:5px;">

            </div>
            <div id="DeductionGroupForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

            </div>
        </div>

        <div class="tab-pane" id="tabPageDeduction">
            <div id="Deduction" class="reviewBlock" data-content="List" style="padding-left:5px;">

            </div>
            <div id="DeductionForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

            </div>
        </div>

        <div class="tab-pane" id="tabPagePayslipTemplate">
            <div id="PayslipTemplate" class="reviewBlock" data-content="List" style="padding-left:5px;">

            </div>
            <div id="PayslipTemplateForm" class="reviewBlock" data-content="Form" style="padding-left:5px;display:none;">

            </div>
        </div>




    </div>

</div>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> -->
<script>
    var modJsList = new Array();

    modJsList['tabPayday'] = new PaydayAdapter('PayFrequency', 'Payday');
    modJsList['tabPayroll'] = new PayrollAdapter('Payroll', 'Payroll');

    modJsList['tabPayrollData'] = new PayrollDataAdapter('PayrollData', 'PayrollData');
    modJsList['tabPayrollData'].setRemoteTable(false);
    modJsList['tabPayrollData'].setShowAddNew(false);
    modJsList['tabPayrollData'].setModulePath('admin=payroll');
    modJsList['tabPayrollData'].setRowFieldName('employee');
    modJsList['tabPayrollData'].setColumnFieldName('payroll_item');
    modJsList['tabPayrollData'].setTables('PayrollEmployee', 'PayrollColumn', 'PayrollData');

    modJsList['tabPayrollColumn'] = new PayrollColumnAdapter('PayrollColumn', 'PayrollColumn', '', 'deduction_group, colorder');
    modJsList['tabPayrollColumn'].setRemoteTable(true);
    //modJsList['tabPayrollColumnTemplate'] = new PayrollColumnTemplateAdapter('PayrollColumnTemplate','PayrollColumnTemplate');

    modJsList['tabPayrollEmployee'] = new PayrollEmployeeAdapter('PayrollEmployee', 'PayrollEmployee');
    // modJsList['tabPayrollEmployee'].setRemoteTable(true);

    modJsList['tabPayslipTemplate'] = new PayslipTemplateAdapter('PayslipTemplate', 'PayslipTemplate');
    // modJsList['tabPayslipTemplate'].setRemoteTable(true);


    //this line of code allows you to connect the UI with data, the data is made up of 
    //datatables and data from the database
    modJsList['tabPayTest'] = new PayrollEmployeeAdapter('PayrollEmployee', 'PayTest');
    // modJsList['tabPayTest'].setRemoteTable(true);

    var modJs = modJsList['tabPayrollEmployee'];

    $(".saveBtnTable").off().on('click', function() {
        modJsList['tabPayrollData'].sendAllCellDataUpdates();
        // modJsList['tabPayrollData'].sendCellDataUpdates();
        // $(".saveBtnTable").hide();
        // let id_ = $('#id').val();
        // alert(id_);

    });

    $(".completeBtnTable").off().on('click', function(e) {
        modJsList['tabPayrollData'].sendAllCellDataUpdates_();


        $(".completeBtnTable").hide();
        $(".saveBtnTable").hide();
    });

    $(".downloadBtnTable").off().on('click', function() {
        modJsList['tabPayrollData'].downloadPayroll();
    });

    //this function handles downloading of payroll in excel format
    $(".downloadBtnTableExcel").off().on('click', function() {
        modJsList['tabPayrollData'].downloadPayrollExcel();
    });

    //this function is responsible for generating a pdf format of the payroll 
    //processing
    $(".downloadBtnTablePdf").off().on('click', function() {

        //get the payroll report data
        let data = modJsList['tabPayrollData'].downloadPayrollPdf();

        //import the jspdf
        const {
            jsPDF
        } = window.jspdf;

        //create a new object instance
        const doc = new jsPDF();

        //add data to the document with margins set
        doc.text(data, 10, 10);
        doc.setFontSize(6);
        doc.save("payroll-report.pdf");
    });

    $(".verifyBtnTable").off().on('click', function() {

        $(".completeBtnTable").hide();
        $(".saveBtnTable").hide();
        $(".completeBtnTable").hide();
        $(".verifyBtnTable").hide();
        alert("Verified");
        modJsList['tabPayrollData'].verifyPayroll();

    });

    $(".cancelBtnTable").off().on('click', function() {
        modJs = modJsList['tabPayroll'];
        modJs.get([]);
    });

    modJsList['tabDeduction'] = new DeductionAdapter('Deduction', 'Deduction');
    // modJsList['tabDeduction'].setRemoteTable(true);

    modJsList['tabDeductionGroup'] = new DeductionGroupAdapter('DeductionGroup', 'DeductionGroup');
    // modJsList['tabDeductionGroup'].setRemoteTable(true);
</script>
<?php include APP_BASE_PATH . 'footer.php'; ?>