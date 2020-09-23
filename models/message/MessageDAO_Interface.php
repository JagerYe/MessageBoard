<?php
interface MessageDAO
{
    public function insertMessage($boardID, $userID, $message, $dbh = null);
    public function updateMessage($messageID, $message);
    public function getOneMessageByID($id);
    public function getAllMessageByBoardID($id);
    public function deleteMessageByID($id);
}
