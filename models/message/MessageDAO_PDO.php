<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/message/MessageDAO_Interface.php";
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
            $sth = $dbh->prepare("INSERT INTO `messages`(`boardID`, `userID`, `creationDate`, `changeDate`, `message`)
                                    VALUES (:boardID,:userID,NOW(),NOW(),:message);");
            $sth->bindParam("boardID", $boardID);
            $sth->bindParam("userID", $userID);
            $sth->bindParam("message", $message);
            $sth->execute();
            $id = $dbh->lastInsertId();
            $dbh->commit();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return 'false';
        }
        $dbh = null;
        return $id;
    }

    //更新
    public function updateMessage($messageID, $message)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `messages` SET `changeDate`=NOW(),`message`=:message WHERE `messageID`=:messageID");

            $sth->bindParam("messageID", $messageID);
            $sth->bindParam("message", $message);
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
            $sth = $dbh->prepare("SELECT `messageID`, `boardID`, mes.`userID`, mes.`creationDate`, mes.`changeDate`, `message`, `userName` FROM `Messages` AS mes
                INNER JOIN `Members` AS mem ON mes.`userID`=mem.`userID`
                WHERE `boardID`=:boardID
                ORDER BY `messageID`;");
            $sth->bindParam("boardID", $id);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return 'false';
        }
        $dbh = null;
        return $request;
    }

    //取得單留言板部分留言
    public function getSomeMessageByBordID($boardID, $startMessageID = -1)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `messageID`, `boardID`, mes.`userID`, mes.`creationDate`, mes.`changeDate`, `message`, `userName` FROM `Messages` AS mes
                                    INNER JOIN `Members` AS mem ON mes.`userID`=mem.`userID`
                                    WHERE `boardID`=:boardID && `messageID`>:messageID
                                    ORDER BY `messageID`
                                    LIMIT 5;");
            $sth->bindParam("boardID", $boardID);
            $sth->bindParam("messageID", $startMessageID);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return 'false';
        }
        $dbh = null;
        return $request;
    }

    //取得一個的留言
    public function getOneMessageByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `messageID`, `boardID`, mes.`userID`, mes.`creationDate`, mes.`changeDate`, `message`, `userName` FROM `Messages` AS mes
                                    INNER JOIN `Members` AS mem ON mes.`userID`=mem.`userID`
                                    WHERE `messageID`=:messageID
                                    ORDER BY `messageID`;");
            $sth->bindParam("messageID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return $request;
    }

    //取得單留言板的第一筆及最後一筆MessageID
    public function getBoardFirstAndLastMessageIDByBoardID($boardID)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `messageID` AS `firstID`, 
                                        (SELECT `messageID` FROM `Messages`
                                        WHERE `boardID`=m1.`boardID`
                                        ORDER BY `messageID` DESC LIMIT 1) AS `lastID`
                                    FROM `Messages` AS m1 WHERE `boardID`=:boardID ORDER BY `messageID` LIMIT 1;");
            $sth->bindParam("boardID", $boardID);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return 'false';
        }
        $dbh = null;
        return $request;
    }

    public function deleteMessageByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("DELETE FROM `Messages` WHERE `messageID`=:messageID;");
            $sth->bindParam("messageID", $id);
            $sth->execute();
            $dbh->commit();
            $request = $sth->rowCount();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return 'false';
        }
        $dbh = null;
        return $request > 0;
    }

    public function deleteMessageByBoardID($id, $dbh)
    {
        try {
            $sth = $dbh->prepare("DELETE FROM `Messages` WHERE `boardID`=:boardID;");
            $sth->bindParam("boardID", $id);
            $sth->execute();
            $request = $sth->rowCount();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return false;
        }
        return $request > 0;
    }

    //確認是主留言後，回傳BoardID
    public function checkIsBoardByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `boardID` FROM `Messages` AS m1 WHERE
                ( SELECT `messageID` FROM `Messages` AS m2 WHERE m1.`boardID`=m2.`boardID` ORDER BY `messageID` LIMIT 1 ) =:messageID 
                && `messageID`=:messageID;");
            $sth->bindParam("messageID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_NUM);
            $sth = null;
        } catch (PDOException $err) {
            $dbh = null;
            return 'false';
        }
        $dbh = null;
        return isset($request['0']) ? $request['0'] : 'false';
    }
}
