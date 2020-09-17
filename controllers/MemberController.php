<?php
class MemberController extends Controller
{
    public function __construct()
    {
        $this->requireDAO("member");
    }

    public function insertByObj($str, $requestMethod)
    {
        if ($requestMethod != 'POST') {
            return false;
        }

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

    public function update($str, $requestMethod)
    {
        if (!isset($_SESSION['userID']) || $requestMethod != 'PUT') {
            return false;
        }

        $jsonObj = json_decode($str);
        $member = new Member();
        $member->setUserID($_SESSION['userID']);
        $member->setUserName($jsonObj->userName);
        $member->setUserEmail($jsonObj->userEmail);
        $member->setUserPhone($jsonObj->userPhone);
        $member->setUserPassword($jsonObj->userPassword);

        $memberDAO = MemberService::getDAO();

        if (
            $memberDAO->checkPassword(
                $member->getUserID(),
                $member->getUserPassword()
            ) && $memberDAO->updateMember($member)
        ) {
            return true;
        }
        return false;
    }

    public function updateSelfPassword($str, $requestMethod)
    {
        $jsonObj = json_decode($str);
        $member = new Member();
        $member->setUserPassword($jsonObj->userPassword);
        if ((!isset($_SESSION['userID'])) || ($requestMethod != 'PUT') || ($member->getUserPassword() != $jsonObj->userPasswordAgain)) {
            return false;
        }

        $memberDAO = MemberService::getDAO();
        if (
            $memberDAO->checkPassword($_SESSION['userID'], $jsonObj->userOldPassword)
            &&
            $memberDAO->updatePassword($_SESSION['userID'], $member->getUserPassword())
        ) {
            $this->logout();
            return true;
        }
        return false;
    }

    public function getAll()
    {
        if (!isset($_SESSION['empID'])) {
            return false;
        }

        if ($members = MemberService::getDAO()->getAllMember()) {
            return json_encode($members);
        }
        return false;
    }

    public function getOne($id)
    {
        if (!isset($_SESSION['empID'])) {
            return false;
        }

        if ($member = MemberService::getDAO()->getOneMemberByID($id)) {
            return json_encode($member);
        }
        return false;
    }

    public function getMemberSelfData()
    {
        if ($member = MemberService::getDAO()->getOneMemberByID($_SESSION['userID'])) {
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
