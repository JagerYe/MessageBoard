<?php
interface BoardDAO
{
    public function insertBoard($userID, $authority, $message);
    public function getUpdateDateByMessageID($messageID);
    public function getOneBoardByID($id);
    public function getAllUserBoardByUserID($id);
    public function deleteByID($id);
}
