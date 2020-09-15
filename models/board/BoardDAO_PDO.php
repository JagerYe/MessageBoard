<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/board/BoardDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/message/MessageService.php";
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
            if (!($messageDAO->insertMessage(
                $id,
                $userID,
                $message->getMessage(),
                $dbh
            ))) {
                throw new Exception("新增錯誤");
            }

            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            return false;
        } catch (Exception $err) {
            return false;
        }
        $dbh = null;
        return $id;
    }

    //更新
    public function updateBoard($Board)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("UPDATE `Boards` SET `changeDate`=NOW(),`authority`=:authority
                                    WHERE `boardID`=:boardID && `userID`=:userID;");
            $sth->bindParam("userID", $Board->getUserID());
            $sth->bindParam("userName", $Board->getUserName());
            $sth->bindParam("authority", $Board->getAuthority());
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
            return false;
        }
        $dbh = null;
        return Board::dbDatasToModelsArray($request);
    }

    //取得單會員所有留言板
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

    //取得一個的留言板
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
}
