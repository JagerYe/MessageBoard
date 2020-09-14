<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/member/MemberDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/config.php";
class MemberDAO_PDO implements MemberDAO
{
    //新增會員
    public function insertMember($id, $password, $name, $email, $phone)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `Members`( `userAccount`, `userPassword`, `userName`, `userEmail`, `userPhone`, `creationDate`, `changeDate`) VALUES(
                (SELECT :userAccount WHERE (SELECT COUNT(`userID`) FROM `Members` AS m WHERE `userAccount`=:userAccount) = 0),
                :userPassword, :userName, :userEmail, :userPhone, NOW(), NOW()
            );");
            $sth->bindParam("userAccount", $id);
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
    public function updateMember($member)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `Members` SET
                                    `userPassword`=:userPassword,
                                    `userName`=:userName,
                                    `userEmail`=:userEmail,
                                    `userPhone`=:userPhone,
                                    `changeDate`=NOW()
                                    WHERE `userID`=:userID;");
            $sth->bindParam("userID", $member->getUserID());
            $sth->bindParam("userPassword", $member->getUserPassword());
            $sth->bindParam("userName", $member->getUserName());
            $sth->bindParam("userEmail", $member->getUserEmail());
            $sth->bindParam("userPhone", $member->getUserPhone());
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

    public function getAllMember()
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->query("SELECT * FROM `Members`;");
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return Member::dbDatasToModelsArray($request);
    }
    public function getOneMemberByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `Members` WHERE `userID` = :userID;");
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return Member::dbDataToModel($request);
    }

    public function doLogin($account, $password)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT COUNT(`userID`) FROM `members` WHERE `userAccount`=:userAccount;");
            $sth->bindParam("userAccount", $account);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            if ($request['check'] != 1) {
                throw new Exception("帳號密碼錯誤");
            }

            //取得密碼
            $sth = $dbh->prepare("SELECT `userPassword` FROM `members` WHERE `userID`=:userID");
            $sth->bindParam("userID", $request['userID']);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (PDOException $err) {
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return password_verify($password, $request['0']);
    }

    public function checkMemberExist($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("SELECT COUNT(*) FROM `Members` WHERE `userID` = :userID;");
            $sth->bindParam("userID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
        } catch (Exception $err) {
            return false;
        }
        return $request['0'];
    }
}
