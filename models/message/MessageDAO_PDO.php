<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/message/MessageDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/oldMessage/OldMessageService.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/config.php";
class MessageDAO_PDO implements MessageDAO
{
    //新增
    public function insertMessage($boardID, $userID, $message, $dbh = null)
    {
        try {
            if ($dbh == null) {
                $dbh = Config::getDBConnect();
                $dbh->beginTransaction();
            }
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
            $oldMessage = $this->getOneMessageByID($Message->getUserID());
            $dbh->beginTransaction();
            $oldMessageDAO = OldMessageService::getDAO();
            if (!($oldMessageDAO->insertOldMessage(
                $oldMessage->getMessageID(),
                $oldMessage->getCreationDate(),
                $oldMessage->getMessage(),
                $dbh
            ))) {
                throw new Exception("更新錯誤");
            }
            $sth = $dbh->prepare("UPDATE `messages` SET `creationDate`=NOW(),`message`=:message WHERE `messageID`=:messageID");
            $sth->bindParam("messageID", $Message->getMessageID());
            $sth->bindParam("message", $Message->getMessage());
            $sth->execute();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        } catch (Exception $err) {
            return false;
        }
        $dbh = null;
        return true;
    }

    //取得單留言板所有留言
    public function getAllMessageByBoardID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `messageID`, `boardID`, mes.`userID`, mes.`creationDate`, `message`, `userName` FROM `Messages` AS mes
                INNER JOIN `Members` AS mem ON mes.`userID`=mem.`userID`
                WHERE `boardID`=:boardID
                ORDER BY `messageID`;");
            $sth->bindParam("boardID", $id);
            $sth->execute();
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
            $sth = $dbh->prepare("SELECT `messageID`, `boardID`, mes.`userID`, mes.`creationDate`, `message`, `userName` FROM `Messages` AS mes
                                    INNER JOIN `Members` AS mem ON mes.`userID`=mem.`userID`
                                    WHERE `messageID`=:messageID
                                    ORDER BY `messageID`;");
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

    public function deleteMessageByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $oldMessageDAO = (new OldMessageService)->getDAO();
            $oldMessageDAO->deleteAllByMessageID($id);
            $sth = $dbh->prepare("DELETE FROM `Messages` WHERE `messageID`=:messageID;");
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
