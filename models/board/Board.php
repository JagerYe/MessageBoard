<?php
class Board implements \JsonSerializable
{
    private $_boardID;
    private $_userID;
    private $_creationDate;
    private $_changeDate;
    private $_authority; //權限

    private $_dateRule = "/\d{1,4}-((1[0-2])|(0?[1-9]))-((3[01])|([12]\d)|(0?[1-9])) ((2[0-4])|([01]?\d)){1}\:[0-5][0-9]\:[0-5][0-9]/";

    public static function dbDatasToModelsArray($request)
    {
        foreach ($request as $item) {
            $board = new Board();
            $board->setBoardID($item['boardID']);
            $board->setUserID($item['userID']);
            $board->setAuthority($item['authority']);
            $board->setCreationDate($item['creationDate']);
            $board->setChangeDate($item['changeDate']);
            $boards[] = $board;
        }
        return $boards;
    }

    public static function dbDataToModel($request)
    {
        $board = new Board();
        $board->setBoardID($request['boardID']);
        $board->setUserID($request['userID']);
        $board->setAuthority($request['authority']);
        $board->setCreationDate($request['creationDate']);
        $board->setChangeDate($request['changeDate']);
        return $board;
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

    public function getBoardID()
    {
        return $this->_boardID;
    }
    public function setBoardID($boardID)
    {
        if ($boardID == null) {
            throw new Exception("留言板格式錯誤");
        }
        $this->_boardID = $boardID;
        return true;
    }

    public function getAuthority()
    {
        return $this->_authority;
    }
    public function setAuthority($authority)
    {
        if ($authority === null) {
            throw new Exception("權限錯誤");
        }
        $this->_authority = $authority;
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
