<?php
namespace Conversations\User\Api;

use cebe\markdown\MarkdownExtra;
use Classes\BaseService;
use Classes\FileService;
use Classes\IceConstants;
use Classes\IceResponse;
use Classes\SubActionManager;
use Conversations\Common\Model\Conversation;
use Employees\Common\Model\Employee;
use ForceUTF8\Encoding;
use Stripe\Error\Base;

class ConversationsActionManager extends SubActionManager
{
    public function addConversation($req)
    {
        $conversation = new Conversation();
        $conversation->message = nl2br($req->message);
        $conversation->attachment = isset($req->attachment) ? $req->attachment : null;
        $conversation->type = $req->type;
        $conversation->employee = $this->getCurrentUserProfileId();
        $conversation->target = isset($req->target) ? $req->target : null;
        $conversation->timeint = time();

        $currentEmployeeTimeZone = BaseService::getInstance()->getCurrentEmployeeTimeZone();
        date_default_timezone_set('Asia/Colombo');

        $date = new \DateTime("now", new \DateTimeZone('Asia/Colombo'));

        $date->setTimezone(new \DateTimeZone($currentEmployeeTimeZone));
        $conversation->created = $date->format('Y-m-d H:i:s');
        $conversation->updated = $conversation->created;

        $ok = $conversation->Save();
        if (!$ok) {
            return new IceResponse(IceResponse::ERROR, $conversation->ErrorMsg());
        }

        if ($conversation->type === 'Announcement') {
            $employee = new Employee();
            $employee->Load('id = ?', array($conversation->employee));

            $notificationMsg = $employee->first_name." ".$employee->middle_name." ".$employee->last_name
                ." posted a new Announcement on "
                .date("F j, Y, g:i a", strtotime($conversation->created));
            $this->baseService->notificationManager->addNotificationToAll(
                $notificationMsg,
                '{"type":"url","url":"g=modules&n=announcements&m=module_Discussions"}',
                IceConstants::NOTIFICATION_ANNOUNCEMENT,
                $conversation->employee,
                null,
                false,
                true
            );
        }

        return new IceResponse(IceResponse::SUCCESS, $conversation);
    }

    protected function calculateClientTime()
    {
    }


    public function getConversations($req)
    {

        $start = $req->start;
        $limit = $req->limit;
        $top = $req->top;
        $type = $req->type;

        $conversation = new Conversation();
        if (!$top) {
            if ($start === 0) {
                $conversations = $conversation->Find(
                    "type = ? order by timeint desc limit ?",
                    array($type, $limit + 1)
                );
            } else {
                $conversations = $conversation->Find(
                    "type = ? and timeint < ? order by timeint desc limit ?",
                    array($type, $start, $limit + 1)
                );
            }
        } else {
            if ($start === 0) {
                $conversations = $conversation->Find(
                    "type = ? order by timeint desc limit ?",
                    array($type, $limit + 1)
                );
            } else {
                $conversations = $conversation->Find(
                    "type = ? and timeint > ? order by timeint limit ?",
                    array($type, $start, $limit + 1)
                );
            }
        }


        $enrichedConversations = [];
        foreach ($conversations as $conversation) {
            $enrichedConversations[] = $this->enrichConversation($conversation);
        }

        return new IceResponse(IceResponse::SUCCESS, $enrichedConversations);
    }

    protected function enrichConversation($conversation)
    {
        $employee = new Employee();
        $employee->Load('id = ?', array($conversation->employee));
        $employee = FileService::getInstance()->updateSmallProfileImage($employee);

        $conversation->employeeName = $employee->first_name.' '.$employee->last_name;
        $conversation->employeeImage = $employee->image;

        $conversation->date = date("F j, Y, g:i a", strtotime($conversation->created));

        if ($conversation->type === 'Announcement') {
            $parser = new MarkdownExtra();
            $message = $this->removeNonUTF($conversation->message);
            $message = Encoding::fixUTF8($message);
            $message = str_replace('â??', '', $message);
            $conversation->message =  $parser->parse($message);
        }


        $conversation = $this->updateAllowedActions($conversation);

        if (!empty($conversation->attachment)) {
            $conversation->file = FileService::getInstance()->getFileData($conversation->attachment);
        }

        return $conversation;
    }

    protected function updateAllowedActions($conversation)
    {
        $currentEmployee = BaseService::getInstance()->getCurrentUserProfileId();
        $conversation->actionDelete = 0;
        if ($this->user->user_level === 'Admin' || $currentEmployee === $conversation->employee) {
            $conversation->actionDelete = 1;
        }

        return $conversation;
    }

    public function deleteConversation($req)
    {

        $conversation = new Conversation();
        $conversation->Load('id = ?', array($req->id));

        if ($conversation->id !== $req->id) {
            return new IceResponse(IceResponse::ERROR, 'Conversation not found');
        }

        $conversation = $this->updateAllowedActions($conversation);

        if ($conversation->actionDelete === 1) {
            $resp = BaseService::getInstance()->deleteElement('Conversation', $req->id);

            if ($resp->getStatus() === IceResponse::SUCCESS) {
                return new IceResponse(IceResponse::SUCCESS, $req->id);
            }
        }

        return new IceResponse(IceResponse::ERROR, false);
    }

    protected function removeNonUTF($text)
    {
        $regex = <<<'END'
/
  (
    (?: [\x00-\x7F]                 # single-byte sequences   0xxxxxxx
    |   [\xC0-\xDF][\x80-\xBF]      # double-byte sequences   110xxxxx 10xxxxxx
    |   [\xE0-\xEF][\x80-\xBF]{2}   # triple-byte sequences   1110xxxx 10xxxxxx * 2
    |   [\xF0-\xF7][\x80-\xBF]{$text3}   # quadruple-byte sequence 11110xxx 10xxxxxx * 3 
    ){1,100}                        # ...one or more times
  )
| .                                 # anything else
/x
END;
        return preg_replace($regex, '$1', $text);
    }
}
