<?php
interface MemberDAO
{
    public function insertMember($account, $password, $name, $email, $phone);
    public function updateMember($member);
    public function updatePassword($userID, $password);
    public function getOneMemberByID($userID);
    public function doLogin($account, $password);
    public function checkPassword($userID, $password, $dbh = null);
    public function checkMemberExist($id);
}
