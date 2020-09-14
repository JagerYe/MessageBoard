<?php
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/board/BoardDAO_Interface.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/config.php";
class BoardDAO_PDO implements BoardDAO
{
    //新增
    public function insertBoard($userID, $authority)
    {
        try {
            $dbh = Config::getDBConnect();
            $dbh->beginTransaction();
            $sth = $dbh->prepare("INSERT INTO `Boards`(`userID`, `creationDate`, `changeDate`, `authority`)
                                    VALUES (:userID,NOW(),NOW(),:authority);");
            $sth->bindParam("userID", $id);
            $sth->bindParam("authority", $authority);
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

    //取得單會員所有留言板
    public function getAllUserBoardByUserID($id)
    {
        try {
            $dbh = Config::getDBConnect();
            $sth = $dbh->prepare("SELECT * FROM `Boards` WHERE `userID`=:userID;");
            $sth->bindParam("userID", $id);
            $request = $sth->fetchAll(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            $dbh->rollBack();
            echo ($err->__toString());
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
            $sth = $dbh->prepare("SELECT * FROM `Boards` WHERE `boardID`=:boardID;");
            $sth->bindParam("boardID", $id);
            $sth->execute();
            $request = $sth->fetch(PDO::FETCH_ASSOC);
            $sth = null;
        } catch (PDOException $err) {
            echo ($err->__toString());
            return false;
        }
        $dbh = null;
        return Board::dbDataToModel($request);
    }
}
