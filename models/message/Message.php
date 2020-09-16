<?php
class Message implements \JsonSerializable
{
    private $_messageID;
    private $_boardID;
    private $_userID;
    private $_creationDate;
    private $_changeDate;
    private $_message;
    private $_userName;

    private $_dateRule = "/\d{1,4}-((1[0-2])|(0?[1-9]))-((3[01])|([12]\d)|(0?[1-9])) ((2[0-4])|([01]?\d)){1}\:[0-5][0-9]\:[0-5][0-9]/";

    public static function dbDatasToModelsArray($request)
    {
        foreach ($request as $item) {
            $message = new Message();
            $message->setMessageID($item['messageID']);
            $message->setUserID($item['userID']);
            $message->setBoardID($item['boardID']);
            $message->setMessage($item['message']);
            $message->setCreationDate($item['creationDate']);
            $message->setChangeDate($item['changeDate']);
            $message->setUserName($item['userName']);
            $messages[] = $message;
        }
        return $messages;
    }

    public static function dbDataToModel($request)
    {
        $message = new Message();
        $message->setMessageID($request['messageID']);
        $message->setUserID($request['userID']);
        $message->setBoardID($request['boardID']);
        $message->setMessage($request['message']);
        $message->setCreationDate($request['creationDate']);
        $message->setChangeDate($request['changeDate']);
        $message->setUserName($request['userName']);
        return $message;
    }

    public function getMessageID()
    {
        return $this->_messageID;
    }
    public function setMessageID($messageID)
    {
        if (!preg_match("/\d/", $messageID)) {
            throw new Exception("ID格式錯誤");
        }
        $this->_messageID = $messageID;
        return true;
    }

    public function getBoardID()
    {
        return $this->_boardID;
    }
    public function setBoardID($boardID)
    {
        if (!preg_match("/\d/", $boardID)) {
            throw new Exception("ID格式錯誤");
        }
        $this->_boardID = $boardID;
        return true;
    }

    public function getUserID()
    {
        return $this->_userID;
    }
    public function setUserID($userID)
    {
        if (!preg_match("/\d/", $userID)) {
            throw new Exception("ID格式錯誤");
        }
        $this->_userID = $userID;
        return true;
    }

    public function getCreationDate()
    {
        return $this->_creationDate;
    }
    public function setCreationDate($creationDate)
    {
        if (!preg_match($this->_dateRule, $creationDate)) {
            throw new Exception("日期錯誤");
        }
        $this->_creationDate = $creationDate;
        return true;
    }

    public function getChangeDate()
    {
        return $this->_changeDate;
    }
    public function setChangeDate($changeDate)
    {
        if (!preg_match($this->_dateRule, $changeDate)) {
            throw new Exception("日期錯誤");
        }
        $this->_changeDate = $changeDate;
        return true;
    }

    public function getUserName()
    {
        return $this->_userName;
    }
    public function setUserName($userName)
    {
        $this->_userName = $userName;
        return true;
    }

    public function getMessage()
    {
        return $this->_message;
    }
    public function setMessage($message)
    {
        if ($message == null) {
            throw new Exception("留言為空");
        }
        $this->_message = $message;
        return true;
    }

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
