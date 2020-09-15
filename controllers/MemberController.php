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
        $member->setUserAccount($jsonObj->userAccount);
        $member->setUserPassword($jsonObj->userPassword);
        $member->setUserName($jsonObj->userName);
        $member->setUserEmail($jsonObj->userEmail);
        $member->setUserPhone($jsonObj->userPhone);

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
        $member->setUserAccount($_SESSION['userAccount']);
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

    public function login($userAccount, $password)
    {
        if (($data = MemberService::getDAO()->doLogin($userAccount, $password))->check) {
            $member = MemberService::getDAO()->getOneMemberByID($data->userID);

            $_SESSION["userAccount"] = $member->getUserAccount();
            $_SESSION["userName"] = $member->getUserName();
            $_SESSION["userID"] = $member->getUserID();

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

    public function getSessionUserID()
    {
        if (isset($_SESSION['userID'])) {
            return $_SESSION['userID'];
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['userAccount']);
        unset($_SESSION['userName']);
        unset($_SESSION['userID']);
    }

    public function checkMemberExist($id)
    {
        return (MemberService::getDAO()->checkMemberExist($id)) > 0;
    }
}
