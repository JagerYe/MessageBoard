<?php
interface OldMessageDAO
{
    public function insertOldMessage($messageID, $creationDate, $message, $dbh);
    public function getAllOldMessageByMessageID($messageID);
    public function deleteAllByMessageID($messageID);
}
