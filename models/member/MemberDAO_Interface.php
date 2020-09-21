<?php
interface MemberDAO
{
    public function insertMember($account, $password, $name, $email, $phone);
    public function updateMember($userID, $userName, $userEmail, $userPhone);
    public function updatePassword($userID, $password);
    public function getOneMemberByID($id);
    public function getOneMemberByUserAccount($userAccount);
    public function doLogin($account, $password);
    public function checkPassword($userID, $password, $dbh = null);
    public function checkMemberExist($id);
}
