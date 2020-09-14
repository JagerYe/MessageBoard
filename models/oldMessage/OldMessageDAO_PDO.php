<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/oldmessage/OldMessageDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/config.php";
class OldMessageDAO_PDO implements OldMessageDAO
{
    //新增
    public function insertOldMessage($messageID, $creationDate, $message)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `oldmessage`(`messageID`, `creationDate`, `message`)
                                    VALUES (:messageID,:creationDate,:message);");
            $sth->bindParam("messageID", $boardID);
            $sth->bindParam("creationDate", $creationDate);
            $sth->bindParam("message", $message);
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

    //取得單留言板所有留言
    public function getAllOldMessageByMessageID($messageID)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `oldmessage` WHERE `messageID`=:messageID;");
            $sth->bindParam("messageID", $messageID);
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return Message::dbDatasToModelsArray($request);
    }

    //取得一個的留言
    public function deleteAllByMessageID($messageID)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("DELETE FROM `oldmessage` WHERE `messageID`=:messageID;");
            $sth->bindParam("messageID", $messageID);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (PDOException $err) {
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return $request['0'];
    }
}
