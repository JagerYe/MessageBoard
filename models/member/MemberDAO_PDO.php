<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/member/MemberDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/config.php";
class MemberDAO_PDO implements MemberDAO
{
    //新增會員
    public function insertMember($account, $password, $name, $email, $phone)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `Members`( `userAccount`, `userPassword`, `userName`, `userEmail`, `userPhone`, `creationDate`, `changeDate`) VALUES(
                (SELECT :userAccount WHERE (SELECT COUNT(`userID`) FROM `Members` AS m WHERE `userAccount`=:userAccount) = 0),
                :userPassword, :userName, :userEmail, :userPhone, NOW(), NOW()
            );");
            $sth->bindParam("userAccount", $account);
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sth->bindParam("userPassword", $password);
            $sth->bindParam("userName", $name);
            $sth->bindParam("userEmail", $email);
            $sth->bindParam("userPhone", $phone);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return true;
    }

    //更新會員
    public function updateMember($userID, $userName, $userEmail, $userPhone)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `Members` SET
                                    `userName`=:userName,
                                    `userEmail`=:userEmail,
                                    `userPhone`=:userPhone,
                                    `changeDate`=NOW()
                                    WHERE `userID`=:userID;");
            $sth->bindParam("userID", $userID);
            $sth->bindParam("userName", $userName);
            $sth->bindParam("userEmail", $userEmail);
            $sth->bindParam("userPhone", $userPhone);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return true;
    }

    //更新密碼
    public function updatePassword($userID, $password)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `Members` SET `userPassword`=:userPassword,`changeDate`=NOW()
                                    WHERE `userID`=:userID;");
            $password = password_hash($password, PASSWORD_DEFAULT);
            $sth->bindParam("userID", $userID);
            $sth->bindParam("userPassword", $password);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return true;
    }

    //更新圖片
    public function updateImg($userID, $img)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `Members` SET `changeDate`=NOW(),`image`=LOAD_FILE(:image)
                                    WHERE `userID`=:userID;");
            $sth->bindParam("userID", $userID);
            $sth->bindParam("image", $img);
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return true;
    }

    public function getOneMemberByUserAccount($userAccount)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `Members` WHERE `userAccount`=:userAccount;");
            $sth->bindParam("userAccount", $userAccount);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return $request;
    }

    public function getOneMemberByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `Members` WHERE `userID`=:userID;");
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return $request;
    }

    public function getImgByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `image` FROM `Members` WHERE `userID`=:userID;");
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (PDOException $err) {
            return null;
        }
        $dbh = null;
        return isset($request['0']) ? $request['0'] : null;
    }

    public function doLogin($account, $password)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT COUNT(`userID`) AS `check`, `userID` FROM `members` WHERE `userAccount`=:userAccount;");
            $sth->bindParam("userAccount", $account);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            if ($request['check'] != 1) {
                throw new Exception("帳號密碼錯誤");
            }

            $check = $this->checkPassword($request['userID'], $password, $dbh);
            $sth = null;
        } catch (Exception $err) {
            return false;
        }
        $dbh = null;
        return $check;
    }

    public function checkPassword($userID, $password, $dbh = null)
    {
        try {
            if ($dbh === null) {
                $dbh = Config::getDBConnect();
            }
            $sth = $dbh->prepare("SELECT `userPassword` FROM `members` WHERE `userID`=:userID");
            $sth->bindParam("userID", $userID);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        return password_verify($password, $request['0']);
    }

    public function checkMemberExist($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("SELECT COUNT(*) FROM `Members` WHERE `userAccount` = :userAccount;");
            $sth->bindParam("userAccount", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
        } catch (Exception $err) {
            return false;
        }
        return $request['0'] > 0;
    }

    // public function checkEmailExist($email)
    // {
    //     try {
    //         $dbh = Config::getDBConnect();
    //         $dbh->beginTransaction();
    //         $sth = $dbh->prepare("SELECT COUNT(*) FROM `Members` WHERE `userEmail`=:userEmail;");
    //         $sth->bindParam("userEmail", $email);
    //         $sth->execute();
    //         $request = $sth->fetch(PDO::FETCH_NUM);
    //     } catch (Exception $err) {
    //         return false;
    //     }
    //     return $request['0'];
    // }
}
