<?php
class OldMessage implements \JsonSerializable
{
    private $_messageID;
    private $_creationDate;
    private $_message;

    private $_dateRule = "/\d{1,4}-((1[0-2])|(0?[1-9]))-((3[01])|([12]\d)|(0?[1-9])) ((2[0-4])|([01]?\d)){1}\:[0-5][0-9]\:[0-5][0-9]/";

    public static function dbDatasToModelsArray($request)
    {
        foreach ($request as $item) {
            $oldmessage = new OldMessage();
            $oldmessage->setMessageID($item['messageID']);
            $oldmessage->setMessage($item['message']);
            $oldmessage->setCreationDate($item['creationDate']);
            $messages[] = $oldmessage;
        }
        return $messages;
    }

    public static function dbDataToModel($request)
    {
        $oldmessage = new OldMessage();
        $oldmessage->setMessageID($request['messageID']);
        $oldmessage->setMessage($request['message']);
        $oldmessage->setCreationDate($request['creationDate']);
        return $oldmessage;
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
