<?php
class MemberController extends Controller
{
    public function __construct()
    {
        $this->requireDAO("member");
    }

    public function insertByObj($str, $requestMethod)
    {
        if ($requestMethod !== 'POST') {
            return false;
        }

        $jsonObj = json_decode($str);
        $member = new Member();
        try {
            $member->setUserAccount($jsonObj->userAccount);
            $member->setUserPassword($jsonObj->userPassword);
            $member->setUserName($jsonObj->userName);
            $member->setUserEmail($jsonObj->userEmail);
            $member->setUserPhone($jsonObj->userPhone);
        } catch (Exception $err) {
            return  false;
        }

        return MemberService::getDAO()->insertMember(
            $member->getUserAccount(),
            $member->getUserPassword(),
            $member->getUserName(),
            $member->getUserEmail(),
            $member->getUserPhone()
        );
    }

    public function update($str, $requestMethod)
    {
        if (!isset($_SESSION['userID']) || $requestMethod !== 'PUT') {
            return false;
        }

        $jsonObj = json_decode($str);
        $member = new Member();
        try {
            $member->setUserName($jsonObj->userName);
            $member->setUserEmail($jsonObj->userEmail);
            $member->setUserPhone($jsonObj->userPhone);
            $member->setUserPassword($jsonObj->userPassword);
        } catch (Exception $err) {
            return false;
        }

        $memberDAO = MemberService::getDAO();

        if (!$memberDAO->checkPassword(
            $_SESSION['userID'],
            $member->getUserPassword()
        )) {
            return false;
        }

        return $memberDAO->updateMember(
            $_SESSION['userID'],
            $member->getUserName(),
            $member->getUserEmail(),
            $member->getUserPhone()
        );
    }

    public function updateSelfPassword($str, $requestMethod)
    {
        $jsonObj = json_decode($str);
        $member = new Member();
        $member->setUserPassword($jsonObj->userPassword);
        if ((!isset($_SESSION['userID'])) || ($requestMethod !== 'PUT') || ($member->getUserPassword() !== $jsonObj->userPasswordAgain)) {
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
    }

    public function login($userAccount, $password)
    {
        if (MemberService::getDAO()->doLogin($userAccount, $password)) {
            $member = MemberService::getDAO()->getOneMemberByUserAccount($userAccount);

            $_SESSION["userAccount"] = $member['userAccount'];
            $_SESSION["userName"] = $member['userName'];
            $_SESSION["userID"] = $member['userID'];

            return true;
        }
        return false;
    }

    public function getSessionUserName()
    {
        if (isset($_SESSION['userName'])) {
            return $_SESSION['userName'];
        }
        return 'false';
    }

    public function getSessionUserID()
    {
        if (isset($_SESSION['userID'])) {
            return $_SESSION['userID'];
        }
        return 'false';
    }

    public function logout()
    {
        unset($_SESSION['userAccount']);
        unset($_SESSION['userName']);
        unset($_SESSION['userID']);
    }

    public function checkMemberExist($id)
    {
        return MemberService::getDAO()->checkMemberExist($id);
    }

    public function getMemberSelfData()
    {

        return json_encode(MemberService::getDAO()->getOneMemberByID($_SESSION['userID']));
    }

    public function getCreateView()
    {
        $smarty = SmartyConfig::getSmarty();
        $smarty->display('registered.html');
    }

    public function getLoginView()
    {
        $smarty = SmartyConfig::getSmarty();
        $smarty->display('login.html');
    }

    public function getUpdateView()
    {
        $member = MemberService::getDAO()->getOneMemberByID($_SESSION['userID']);
        $smarty = SmartyConfig::getSmarty();
        $smarty->assign('member', $member);
        $smarty->display('updateMemberData.html');
    }

    public function getUpdatePasswordView(){
        $smarty = SmartyConfig::getSmarty();
        $smarty->display('updateMemberPassword.html');
    }
}
