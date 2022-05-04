<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 6:36 PM
 */
namespace Reports\Admin\Api;

use Classes\BaseService;
use Classes\S3FileSystem;
use Classes\UIManager;
use Classes\SettingsManager;
use Model\File;
use Model\ReportFile;
use Utils\LogManager;

abstract class ReportBuilder
{

    protected function execute($report, $query, $parameters)
    {
        $report->DB()->SetFetchMode(ADODB_FETCH_ASSOC);
        LogManager::getInstance()->debug("Query: ".$query);
        LogManager::getInstance()->debug("Parameters: ".json_encode($parameters));
        $rs = $report->DB()->Execute($query, $parameters);
        if (!$rs) {
            LogManager::getInstance()->info($report->DB()->ErrorMsg());
            return array("ERROR","Error generating report");
        }

        $reportNamesFilled = false;
        $columnNames = array();
        $reportData = array();
        foreach ($rs as $rowId => $row) {
            $reportData[] = array();
            if (!$reportNamesFilled) {
                $countIt = 0;
                foreach ($row as $name => $value) {
                    $countIt++;
                    $columnNames[$countIt] = $name;
                    $reportData[count($reportData)-1][] = $value;
                }
                $reportNamesFilled = true;
            } else {
                foreach ($row as $name => $value) {
                    $reportData[count($reportData)-1][] = $this->transformData($name, $value);
                }
            }
        }

        array_unshift($reportData, $columnNames);

        return $reportData;
    }

/*
// TEMPLATES
    protected $twig;
    protected function getDefaultData()
    {
        $defaultData = array();
        $defaultData['BASE_URL'] = BASE_URL;
        $defaultData['LOGO'] = UIManager::getInstance()->getCompanyLogoUrl();
        $defaultData['LOGO'] = str_replace("https:", "http:", $defaultData['LOGO']);
        $compName = $defaultData['companyName'] = SettingsManager::getInstance()->getSetting("Company: Name");
        LogManager::getInstance()->debug("Logo Url:".$defaultData['LOGO']);
        return $defaultData;
    }
   protected function initTemplateEngine($report)
    {
        if ($report->_table = "UserReports") {
            $path = APP_BASE_PATH."modules/reports/customTemplates/";
        } else {
            $path = APP_BASE_PATH."admin/reports/customTemplates/";
        }
        $loader = new \Twig_Loader_Filesystem($path);
        $twigOptions = array();
        //false
        if (defined('CACHE_THEME') && CACHE_THEME) {
            $twigOptions = array(
            );
        } else {
            $twigOptions = array(
                "cache"=>false
            );
        }
        $this->twig = new \Twig_Environment($loader, $twigOptions);
    }


//End of templates

*/
    public function transformData($name, $value)
    {
        $value = '<td>'.$value.'</td>';
        return $value;
    }

    // public function createReportFile($report, $data)
    // {
    //     $fileFirstPart = "Report_".str_replace(" ", "_", $report->name)."-".date("Y-m-d_H-i-s");
    //     $fileName = $fileFirstPart.".csv";

    //     $fileFullName = CLIENT_BASE_PATH.'data/'.$fileName;
    //     $fp = fopen($fileFullName, 'w');

    //     foreach ($data as $fields) {
    //         fputcsv($fp, $fields);
    //     }

    //     fclose($fp);
    //     return array($fileFirstPart, $fileName, $fileFullName);
    // }

    public function createReportFile($report, $data)
    {
        $fileFirstPart = "Report_".str_replace(" ", "_", $report->name)."-".date("Y-m-d_H-i-s");
        $fileName = $fileFirstPart.".html";

        $fileFullName = CLIENT_BASE_PATH.'data/'.$fileName;

    $mysqli = mysqli_connect("localhost", "root", "", "hrmdata");
    if (mysqli_connect_errno($mysqli)) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
     
    $date_query = "SELECT * From payroll";
    $audit_query = "SELECT * FROM auditlog ORDER BY id DESC LIMIT 1";

    $date_res = mysqli_query($mysqli, $date_query);

    $audit_res = mysqli_query($mysqli, $audit_query);

    while ($row = mysqli_fetch_assoc($date_res) ) {

    $date_start = $row['date_start'];
    $date_end = $row['date_end'];      
      # code...
    $date = date("Y-m-d H:i:s");

    }

    while ($row = mysqli_fetch_assoc($audit_res) ) {

    $name = $row['full_name'];
    // $date_end = $row['date_end'];      
    //   # code...
    // $date = date("Y-m-d H:i:s");

    }


    // echo $date_end;

        $fp = fopen($fileFullName, 'w');
        $dd = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/html4/loose.dtd">
            <html>
            <head>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css"/>
            <script type="text/javascript" src="tableExport.js"></script>
            <script type="text/javascript" src="jquery.base64.js"></script>
            <script type="text/javascript" src="html2canvas.js"></script>
            <script type="text/javascript" src="jspdf/libs/sprintf.js"></script>
            <script type="text/javascript" src="jspdf/jspdf.js"></script>
            <script type="text/javascript" src="jspdf/libs/base64.js"></script>
            <script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>  
            <title>Payroll Report - UTB</title>
            <meta charset="utf-8">
            <title>Client Project Timesheet</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="description" content="">
            <meta name="author" content="">
            <link href="{{BASE_URL}}themecss/AdminLTE.css" rel="stylesheet">
            <link href="{{BASE_URL}}themecss/bootstrap.min.css" rel="stylesheet">
            <link href="{{BASE_URL}}themecss/font-awesome.min.css" rel="stylesheet">
            <link href="{{BASE_URL}}themecss/ionicons.min.css" rel="stylesheet">
            <script src="{{BASE_URL}}themejs/bootstrap.js"></script>
            </head>
            <body>


            <h1 align="center"> UNION TRUST BANK LIMITED </h1><br/>
            <h2 align="center"> GENERAL PAYROLL REPORT </h2>

            <h4 align="left">Period:  <b>'.$date_start.'</b> to <b>'.$date_end.'</b> </h4>
            <h4 align="left">Generated On: <b>'.$date.'</b> </h4>
            <h4 align="left">Generated By: <b>'.$name.'</b> </h4>

            
            
            <table id="employees" class="table table-striped">';

        foreach ($data as $fields) {
            $dd .= '<thread>';
            $dd .= '<tr class="warning">'; 
             foreach ($fields as $field) {
                    $dd .= '<td>';
                    $dd .= $field;
                    $dd .= '</td>';
             }           
           
            $dd .= '</tr>';
            $dd .= '</thread>';
        }
 
        $dd.='</table></body></html>';
// </div>
        fputs($fp,$dd);
        fclose($fp);


LogManager::getInstance()->info("=========".implode($data)."========");
/*
        $fp = fopen($fileFullName, 'w');
        while (($data = fgetcsv($fp, 0, ",")) !== false) {
            $num = count($data);
            if ($row == 0) {
                # code...
                for ($c=0; $c < $num; $c++) { 
                    # code...
                   foreach ($data as $fields){ 
                    $dd .= '<table>';
                    $dd .= '<tr>';
                    $dd .= '<td>';
                    $dd .= $fields[$c];
                    $dd .= '</td>';
                    $dd .= '</tr>';
                    $dd .= '</table>';
                    }
                }
            }
            else {
                $data[0];

                for ($c=0; $c < $num; $c++) { 
                    # code...
                    $data[$c];
                }
                $row++;
}       
}
fclose($f);
*/

        try {
            $fileFullNamePdf = CLIENT_BASE_PATH.'data/'.$fileFirstPart.".pdf";


            //Try generating the pdf
            LogManager::getInstance()->debug(
                "wkhtmltopdf 1:".print_r(WK_HTML_PATH." ".$fileFullName." ".$fileFullNamePdf, true)
            );
            exec(WK_HTML_PATH." "."-O landscape"." ".$fileFullName." ".$fileFullNamePdf, $output, $ret);
            

            LogManager::getInstance()->debug("wkhtmltopdf 2:".print_r($output, true));
            LogManager::getInstance()->debug("wkhtmltopdf 3:".print_r($ret, true));

            if (file_exists($fileFullNamePdf)) {
                $fileName = $fileFirstPart.".pdf";
                $fileFullName = $fileFullNamePdf;
            }
        } catch (\Exception $exp) {
        }
        return array($fileFirstPart, $fileName, $fileFullName);
    }


    public function saveFile($fileFirstPart, $file, $fileFullName)
    {
        $uploadedToS3 = false;

        $uploadFilesToS3 = SettingsManager::getInstance()->getSetting("Files: Upload Files to S3");
        $uploadFilesToS3Key = SettingsManager::getInstance()->getSetting("Files: Amazon S3 Key for File Upload");
        $uploadFilesToS3Secret = SettingsManager::getInstance()->getSetting("Files: Amazone S3 Secret for File Upload");
        $s3Bucket = SettingsManager::getInstance()->getSetting("Files: S3 Bucket");
        $s3WebUrl = SettingsManager::getInstance()->getSetting("Files: S3 Web Url");

        if ($uploadFilesToS3.'' == '1' && !empty($uploadFilesToS3Key)
            && !empty($uploadFilesToS3Secret) && !empty($s3Bucket) && !empty($s3WebUrl)) {
            $uploadname = CLIENT_NAME."/".$file;
            $s3FileSys = new S3FileSystem($uploadFilesToS3Key, $uploadFilesToS3Secret);
            $res = $s3FileSys->putObject($s3Bucket, $uploadname, $fileFullName, 'authenticated-read');

            if (empty($res)) {
                return array("ERROR",$file);
            }

            unlink($fileFullName);
            $file_url = $s3WebUrl.$uploadname;
            $file_url = $s3FileSys->generateExpiringURL($file_url);
            $uploadedToS3 = true;
        }

        $fileObj = new File();
        $fileObj->name = $fileFirstPart;
        $fileObj->filename = $file;
        $fileObj->file_group = "Report";
        $ok = $fileObj->Save();

        if (!$ok) {
            LogManager::getInstance()->info($fileObj->ErrorMsg());
            return array("ERROR","Error generating report");
        }

        $reportFile = new ReportFile();
        $reportFile->name = $fileObj->filename;
        $reportFile->attachment = $fileObj->name;
        $reportFile->created = date("Y-m-d H:i:s");
        $reportFile->employee = BaseService::getInstance()->getCurrentProfileId();
        $ok = $reportFile->Save();

        if (!$ok) {
            LogManager::getInstance()->info($reportFile->ErrorMsg());
            return array("ERROR","Error generating report");
        }

        if ($uploadedToS3) {
            return array("SUCCESS",$file_url);
        } else {
            return array("SUCCESS",$file);
        }
    }
}
