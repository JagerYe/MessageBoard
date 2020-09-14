<?php
class Friend implements \JsonSerializable
{
    private $_userID;
    private $_friendID;
    private $_creationDate;
    private $_dateRule = "/\d{1,4}-((1[0-2])|(0?[1-9]))-((3[01])|([12]\d)|(0?[1-9])) ((2[0-4])|([01]?\d)){1}\:[0-5][0-9]\:[0-5][0-9]/";

    public static function dbDatasToModelsArray($request)
    {
        foreach ($request as $item) {
            $friend = new Friend();
            $friend->setUserID($item['userID']);
            $friend->setFriendID($item['friendID']);
            $friend->setCreationDate($item['creationDate']);
            $friends[] = $friend;
        }
        return $friends;
    }

    public static function dbDataToModel($request)
    {
        $friend = new Friend();
        $friend->setUserID($request['userID']);
        $friend->setFriendID($request['friendID']);
        $friend->setCreationDate($request['creationDate']);
        return $friend;
    }

    public function getUserID()
    {
        return $this->_userID;
    }
    public function setUserID($userID)
    {
        if (!preg_match("/\w{6,30}/", $userID)) {
            throw new Exception("ID格式錯誤");
        }
        $this->_userID = $userID;
        return true;
    }

    public function getFriendID()
    {
        return $this->_friendID;
    }
    public function setFriendID($friendID)
    {
        if (!preg_match("/\w{6,30}/", $friendID)) {
            throw new Exception("格式錯誤");
        }
        $this->_friendID = $friendID;
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

    public function jsonSerialize()
    {
        $vars = get_object_vars($this);
        return $vars;
    }
}
