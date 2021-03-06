<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/board/BoardDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/config.php";
class BoardDAO_PDO implements BoardDAO
{
    //新增
    public function insertBoard($userID, $authority, $message)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `Boards`(`userID`, `creationDate`, `changeDate`, `authority`) VALUES
                                    (:userID,NOW(),NOW(),:authority);");
            $sth->bindParam("userID", $userID);
            $sth->bindParam("authority", $authority);
            $sth->execute();
            $id = $dbh->lastInsertId();

            $messageDAO = MessageService::getDAO();
            $messageID = $messageDAO->insertMessage($id, $userID, $message->getMessage(), $dbh);
            if ($messageID <= 0) {
                throw new Exception("新增錯誤");
            }

            $sth = null;
            $data['boardID'] = $id;
            $data['messageID'] = $messageID;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return 'false';
        } catch (Exception $err) {
            return 'false';
        }
        $dbh = null;

        return $data;
    }

    public function getAllPublic()
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `boardID`, `userID`, `creationDate`, `changeDate`, `authority` FROM `Boards`
                                    WHERE `authority`= 0 ORDER BY `boardID` DESC;");
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return 'false';
        }
        $dbh = null;
        return $request;
    }

    public function getSomePublic($id = null)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `boardID`, `userID`, `creationDate`, `changeDate`, `authority` FROM `Boards`
                                    WHERE `authority`= 0 && `boardID`<IFNULL(:boardID, (~0 >> 32)) ORDER BY `boardID` DESC
                                    LIMIT 5;");
            $sth->bindParam("boardID", $id);
            $sth->execute();
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return 'false';
        }
        $dbh = null;
        return $request;
    }

    //取得單會員所有留言板，View未完成
    public function getAllUserBoardByUserID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `boardID`, `userID`, `creationDate`, `changeDate`, `authority` FROM `Boards`
                                    WHERE `userID`=:userID ORDER BY `boardID` DESC;");
            $sth->bindParam("userID", $id);
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        }
        $dbh = null;
        return Board::dbDatasToModelsArray($request);
    }

    //取得一個的留言板，View未完成
    public function getOneBoardByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT `boardID`, b.`userID`, b.`creationDate`, b.`changeDate`, `authority`, `userName` FROM `Boards` AS b
                                    INNER JOIN `Members` AS m ON m.`userID` = b.`userID`
                                    WHERE `boardID`=:boardID ORDER BY `boardID` DESC;");
            $sth->bindParam("boardID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            return false;
        }
        $dbh = null;
        return Board::dbDataToModel($request);
    }

    //刪除
    public function deleteByID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            if (!(MessageService::getDAO()->deleteMessageByBoardID($id, $dbh))) {
                throw new Exception("刪除留言錯誤");
            }
            $sth = $dbh->prepare("DELETE FROM `Boards` WHERE `boardID`=:boardID");
            $sth->bindParam("boardID", $id);
            $sth->execute();
            $dbh->commit();
            $request = $sth->rowCount();
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            $dbh = null;
            return false;
        } catch (Exception $err) {
            return false;
        }
        $dbh = null;
        return $request > 0;
    }
}
