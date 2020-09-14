<?php
interface MessageDAO
{
    public function insertMessage($boardID, $userID, $message);
    public function updateMessage($message);
    public function getOneMessageByID($id);
    public function getAllUserMessageByBoardID($id);
}
