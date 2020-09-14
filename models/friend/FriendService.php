<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/friend/FriendDAO_PDO.php";
class FriendService
{
    public static function getDAO()
    {
        return new FriendDAO_PDO();
    }
}
