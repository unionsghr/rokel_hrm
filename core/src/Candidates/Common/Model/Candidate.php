<?php
namespace Candidates\Common\Model;

use Candidates\Admin\Api\CandidatesActionManager;
use Candidates\Common\Email\CandidatesEmailSender;
use Classes\BaseService;
use Classes\IceResponse;
use JobPositions\Common\Model\Job;
use Model\BaseModel;

class Candidate extends BaseModel
{
    const SOURCE_SOURCED = 'Sourced';
    const SOURCE_APPLIED = 'Applied';

    public $table = 'Candidates';

    public function getAdminAccess()
    {
        return array("get","element","save","delete");
    }

    public function getManagerAccess()
    {
        return array("get","element","save","delete");
    }

    public function getUserAccess()
    {
        return array();
    }

    public function getAnonymousAccess()
    {
        return array("save");
    }

    public function getUserOnlyMeAccess()
    {
        return array("element");
    }

    public function getCustomFilterQuery($filter)
    {
        $query = "";
        $queryData = array();
        foreach ($filter as $k => $v) {
            if (empty($v)) {
                continue;
            }
            $vArr = json_decode($v);
            if (is_array($vArr)) {
                $length = count($vArr);
                $v = $vArr;

                for ($i = 0; $i<$length; $i++) {
                    if ($i == 0) {
                        $query.=" and (";
                    }

                    $query.=$k." like ?";

                    if ($i < $length -1) {
                        $query.=" or ";
                    } else {
                        $query.=")";
                    }
                    $queryData[] = "%".$v[$i]."%";
                }
            } elseif ($k == 'minAge' && !empty($v)) {
                $query.=" and age >=?";
                $queryData[] = $v;
            } elseif ($k == 'maxAge' && !empty($v)) {
                $query.=" and age <=?";
                $queryData[] = $v;
            } elseif ($k == 'minExpYears' && !empty($v)) {
                $query.=" and totalYearsOfExperience >=?";
                $queryData[] = $v;
            } elseif ($k == 'maxExpYears' && !empty($v)) {
                $query.=" and totalYearsOfExperience <=?";
                $queryData[] = $v;
            } elseif ($k == 'minSalary' && !empty($v)) {
                $query.=" and expectedSalary >=?";
                $queryData[] = $v;
            } elseif ($k == 'maxSalary' && !empty($v)) {
                $query.=" and expectedSalary <=?";
                $queryData[] = $v;
            } elseif ($k == 'minDate' && !empty($v)) {
                $query.=" and created >=?";
                $queryData[] = $v;
            } elseif ($k == 'maxDate' && !empty($v)) {
                $query.=" and created <=?";
                $queryData[] = $v;
            } elseif ($k == 'jobId' && !empty($v)) {
                $query.=" and ".$k." = ?";
                $queryData[] = $v;
            } else {
                $query.=" and ".$k."=?";
                $queryData[] = $v;
            }
        }

        return array($query, $queryData);
    }

    public function createCandidateHash($obj)
    {
        $h1 = md5($obj->id."-".$obj->first_name."-".$obj->middle_name."-".$obj->last_name."-".time()."-".rand());
        $h2 = md5($obj->id."-".$obj->cv_title."-".time());
        return $h1.$h2;
    }

    public function executePreSaveActions($obj)
    {
        if (empty($obj->cv_title)) {
            $job = new Job();
            $job->Load('id = ?', [$obj->jobId]);

            $obj->cv_title = !empty($job->title) ? $job->title : sprintf('CV: %s', $obj->first_name);
        }
        return new IceResponse(IceResponse::SUCCESS, $obj);
    }

    public function executePreUpdateActions($obj)
    {
        return $this->executePreSaveActions($obj);
    }

    public function executePostSaveActions($obj)
    {
        //LogManager::getInstance()->info("Save Candidate :".json_encode($_REQUEST));

        //Add candidate hash

        $obj->hash = $this->createCandidateHash($obj);
        $obj->source = 'Sourced';
        $obj->emailSent = 0;
        $obj->Save();

        if (!isset($_POST['jobCode']) || empty($_POST['jobCode'])) {
            return;
        }

        $jobCode = $_POST['jobCode'];
        $job = new Job();
        $job->Load("code = ?", array($jobCode));
        if (!empty($job->id) && $job->code == $jobCode) {
            $obj->jobId = $job->id;
        }

        $hiringPipeline = new HiringPipeline();
        $hiringPipeline->Load('name = ?', ['Applied']);
        $obj->hiringStage = $hiringPipeline->id;
        $obj->source = 'Applied';
        $obj->Save();
    }
}
