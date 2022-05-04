<?php
/**
 * Created by PhpStorm.
 * User: Thilina
 * Date: 8/19/17
 * Time: 4:41 AM
 */

namespace Candidates\Admin\Api;

use Candidates\Common\Email\CandidatesEmailSender;
use Candidates\Common\Model\Application;
use Candidates\Common\Model\Candidate;
use Classes\BaseService;
use Classes\FileService;
use Classes\IceResponse;
use Classes\SubActionManager;
use Company\Common\Model\CompanyStructure;
use JobPositions\Common\Model\Job;

class CandidatesActionManager extends SubActionManager
{

    public function getCandidateObject($req)
    {

        if ($this->user->user_level != 'Admin' && $this->user->user_level != 'Manager') {
            return new IceResponse(IceResponse::ERROR, "Only an admin or manager can do this");
        }

        $id = $req->id;
        $candidate = new Candidate();
        $candidate->Load("id = ?", array($id));

        $fileService = FileService::getInstance();
        $candidate->cv_file = $candidate->cv;
        $candidate->cv = $fileService->getFileUrl($candidate->cv);

        if (!empty($candidate->profileImage)) {
            $candidate->profileImage = $fileService->getFileUrl($candidate->profileImage);
        } else {
            if ($candidate->gender == 'F') {
                $candidate->profileImage = BASE_URL."images/user_female.png";
            } else {
                $candidate->profileImage = BASE_URL."images/user_male.png";
            }
        }
        if (!empty($candidate->generatedCVFile)) {
            $candidate->generatedCVFile = $fileService->getFileUrl($candidate->generatedCVFile);
        }

        return new IceResponse(IceResponse::SUCCESS, $candidate);
    }

    public function sendCVUpdateRequest($req)
    {

        $applicationId = $req->id;
        $application = new Application();
        $application->Load("id = ?", array($applicationId));

        if (empty($application->id)) {
            return new IceResponse(IceResponse::ERROR, "Job application not found");
        }

        $candidate = new Candidate();
        $candidate->Load("id = ?", array($application->candidate));

        if (empty($candidate->id)) {
            return new IceResponse(IceResponse::ERROR, "Candidate not found");
        }

        $job = new Job();
        $job->Load("id = ?", array($application->job));
        if (empty($job->id)) {
            return new IceResponse(IceResponse::ERROR, "Job not found");
        }

        if (empty($candidate->hash)) {
            $candidate->hash = $candidate->createCandidateHash($candidate);
            $candidate->Save();
        }

        $company = new CompanyStructure();
        $company->Load("id = ?", array($job->company));

        $url = CLIENT_BASE_URL."update.php?g=admin&n=candidates&hash=".$candidate->hash;

        if (!empty($this->emailSender)) {
            $candidateEmailSender = new CandidatesEmailSender($this->emailSender, $this);
            $res = $candidateEmailSender->sendDataUpdateRequestEmail($candidate, $job, $company, $url);
            return new IceResponse(IceResponse::SUCCESS, null);
            BaseService::getInstance()->audit(
                "CV Update Email",
                "Job: [$job->id]/$job->title | Candidate: [$candidate->id]/$candidate->email"
            );
        } else {
            return new IceResponse(IceResponse::ERROR, "Email sender is not configured");
            BaseService::getInstance()->audit(
                "CV Update Email Failed",
                "Job: [$job->id]/$job->title | Candidate: [$candidate->id]/$candidate->email"
            );
        }
    }
}
