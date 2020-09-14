<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/message/MessageDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/config.php";
class MessageDAO_PDO implements MessageDAO
{
    //新增
    public function insertMessage($boardID, $userID, $message)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `messages`(`boardID`, `userID`, `creationDate`, `message`)
                                    VALUES (:boardID,:userID,NOW(),:message);");
            $sth->bindParam("boardID", $boardID);
            $sth->bindParam("userID", $userID);
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

    //更新
    public function updateMessage($Message)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `messages` SET `creationDate`=NOW(),`message`=:message WHERE `messageID`=:messageID");
            $sth->bindParam("messageID", $Message->getMessageID());
            $sth->bindParam("message", $Message->getMessage());
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
    public function getAllUserMessageByBoardID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `messages` WHERE `boardID`=:boardID;");
            $sth->bindParam("boardID", $id);
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
    public function getOneMessageByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `messages` WHERE `messageID`=:messageID;");
            $sth->bindParam("messageID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return Message::dbDataToModel($request);
    }
}
