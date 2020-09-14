<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/oldmessage/OldMessageDAO_PDO.php";
class OldMessageService
{
    public static function getDAO()
    {
        return new OldMessageDAO_PDO();
    }
}
