<?php
class Member implements \JsonSerializable
{
    private $_userID;
    private $_userAccount;
    private $_userPassword;
    private $_userName;
    private $_userEmail;
    private $_userPhone;
    private $_creationDate;
    private $_changeDate;
    private $_emailRule = "/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/";
    private $_dateRule = "/\d{1,4}-((1[0-2])|(0?[1-9]))-((3[01])|([12]\d)|(0?[1-9])) ((2[0-4])|([01]?\d)){1}\:[0-5][0-9]\:[0-5][0-9]/";

    public static function dbDatasToModelsArray($request)
    {
        foreach ($request as $item) {
            $member = new Member();
            $member->setUserID($item['userID']);
            $member->setUserAccount($item['userAccount']);
            $member->setUserName($item['userName']);
            $member->setUserEmail($item['userEmail']);
            $member->setUserPhone($item['userPhone']);
            $member->setCreationDate($item['creationDate']);
            $member->setChangeDate($item['changeDate']);
            $members[] = $member;
        }
        return $members;
    }

    public static function dbDataToModel($request)
    {
        $member = new Member();
        $member->setUserID($request['userID']);
        $member->setUserAccount($request['userAccount']);
        $member->setUserName($request['userName']);
        $member->setUserEmail($request['userEmail']);
        $member->setUserPhone($request['userPhone']);
        $member->setCreationDate($request['creationDate']);
        $member->setChangeDate($request['changeDate']);
        return $member;
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

    public function getUserAccount()
    {
        return $this->_userAccount;
    }
    public function setUserAccount($userAccount)
    {
        if (!preg_match("/\w{6,30}/", $userAccount)) {
            throw new Exception("帳號格式錯誤");
        }
        $this->_userAccount = $userAccount;
        return true;
    }

    public function getUserPassword()
    {
        return $this->_userPassword;
    }
    public function setUserPassword($userPassword)
    {
        if (!preg_match("/\w{6,30}/", $userPassword)) {
            throw new Exception("密碼格式錯誤");
        }
        $this->_userPassword = $userPassword;
        return true;
    }

    public function getUserName()
    {
        return $this->_userName;
    }
    public function setUserName($userName)
    {
        if ($userName === null || $userName == "") {
            throw new Exception("名字格式錯誤");
        }
        $this->_userName = $userName;
        return true;
    }

    public function getUserEmail()
    {
        return $this->_userEmail;
    }
    public function setUserEmail($userEmail)
    {

        if (!preg_match($this->_emailRule, $userEmail)) {
            throw new Exception("email格式錯誤");
        }
        $this->_userEmail = $userEmail;
        return true;
    }

    public function getUserPhone()
    {
        return $this->_userPhone;
    }
    public function setUserPhone($userPhone)
    {
        if (!preg_match("/\d{10}/", $userPhone)) {
            throw new Exception("電話錯誤");
        }
        $this->_userPhone = $userPhone;
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
