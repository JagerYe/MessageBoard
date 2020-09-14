<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/friend/FriendDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/config.php";
class FriendDAO_PDO implements FriendDAO
{
    //新增
    public function insertFriend($userID, $friendID)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `Friends`(`userID`, `friendID`, `creationDate`) VALUES (:userID,:friendID,NOW());");
            $sth->bindParam("userID", $id);
            $sth->bindParam("friendID", $friendID);
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

    //取得好友清單
    public function getUserFriends($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `Friends` WHERE `userID`=:userID || `friendID`=:userID;");
            $sth->bindParam("userID",$id);
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return Friend::dbDatasToModelsArray($request);
    }
   
    //確認好友關係
    public function checkFriendship($userID, $friendID)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("SELECT COUNT(*) FROM `Friends`
                WHERE (`userID`=:userID && `friendID`=:friendID) || (`userID`=:friendID && `friendID`=:userID);");
            $sth->bindParam("userID", $id);
            $sth->bindParam("friendID", $friendID);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
        } catch (Exception $err) {
            return false;
        }
        return $request['0'];
    }
}
