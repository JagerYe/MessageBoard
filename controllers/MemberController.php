<?php
class MemberController extends Controller
{
    public function __construct()
    {
        $this->requireDAO("member");
    }

    public function insertByObj($str)
    {
        $jsonObj = json_decode($str);
        $member = new Member();
        $member->setUserAccount($jsonObj['userAccount']);
        $member->setUserPassword($jsonObj['password']);
        $member->setUserName($jsonObj['name']);
        $member->setUserEmail($jsonObj['email']);
        $member->setUserPhone($jsonObj['phone']);

        if (MemberService::getDAO()->insertMember(
            $member->getUserAccount(),
            $member->getUserPassword(),
            $member->getUserName(),
            $member->getUserEmail(),
            $member->getUserPhone()
        )) {
            return true;
        }

        return false;
    }

    public function update($str)
    {
        $jsonObj = json_decode($str);
        $member = new Member();
        $member->setUserID($_SESSION['userID']);
        $member->setUserName($jsonObj['name']);
        $member->setUserEmail($jsonObj['email']);
        $member->setUserPhone($jsonObj['phone']);

        if (MemberService::getDAO()->updateMember($member)) {
            return true;
        }
        return false;
    }

    public function getAll()
    {
        if ($members = MemberService::getDAO()->getAllMember()) {
            return json_encode($members);
        }
        return false;
    }

    public function getOne($id)
    {
        if ($member = MemberService::getDAO()->getOneMemberByID($id)) {
            return json_encode($member);
        }
        return false;
    }

    public function login($id, $password)
    {
        if (MemberService::getDAO()->doLogin($id, $password) == 1) {
            $member = MemberService::getDAO()->getOneMemberByID($id);

            $_SESSION["userID"] = $member->getUserID();
            $_SESSION["userName"] = $member->getUserName();

            return true;
        }
        return false;
    }

    public function getSessionUserName()
    {
        if (isset($_SESSION['userName'])) {
            return $_SESSION['userName'];
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['userID']);
        unset($_SESSION['userName']);
    }

    public function checkMemberExist($id)
    {
        return (MemberService::getDAO()->checkMemberExist($id)) > 0;
    }
}
