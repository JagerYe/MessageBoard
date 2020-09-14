<?php
interface FriendDAO
{
    public function insertFriend($userID, $friendID);
    public function getUserFriends($id);
    public function checkFriendship($userID, $friendID);
}
