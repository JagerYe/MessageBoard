<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/message/MessageDAO_PDO.php";
class MessageService
{
    public static function getDAO()
    {
        return new MessageDAO_PDO();
    }
}
