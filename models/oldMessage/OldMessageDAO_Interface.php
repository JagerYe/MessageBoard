<?php
interface OldMessageDAO
{
    public function insertOldMessage($messageID, $creationDate, $message);
    public function getAllOldMessageByMessageID($messageID);
    public function deleteAllByMessageID($messageID);
}
