<?php
class MemberController extends Controller
{
    private $_dao;
    public function __construct()
    {
        $this->requireDAO("member");
    }

    public function insertByObj($str)
    {

        if (!($member = $this->getJsonToModel("member", $str, true))) {
            return false;
        }


        if (MemberService::getDAO()->insertMemberByObj($member)) {
            return true;
        }

        return false;
    }

    public function update($str)
    {
        if (!($member = $this->getJsonToModel("member", $str))) {
            return false;
        }

        $password = $member->getUserPassword();
        if (!preg_match("/\w{6,30}/", $password)) {
            return false;
        }

        if (MemberService::getDAO()->updateMember($member)) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        if (MemberService::getDAO()->deleteMemberByID($id)) {
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
            $a = json_encode($member);
            return $a;
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
