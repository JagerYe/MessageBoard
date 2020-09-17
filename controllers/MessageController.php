<?php
class MessageController extends Controller
{
    public function __construct()
    {
        $this->requireDAO("Board");
        $this->requireDAO("Message");
    }

    public function addMainMessage($str, $requestMethod)
    {
        //阻擋未登入者
        if (!isset($_SESSION['userID']) || $requestMethod != 'POST') {
            return false;
        }

        $jsonArr = json_decode($str);
        // $board = $jsonArr['board'];
        $board = new Board();
        $board->setAuthority($jsonArr->board->authority);

        $message = new Message();
        $message->setMessage($jsonArr->message->message);
        $data = BoardService::getDAO()->insertBoard($_SESSION['userID'], $board->getAuthority(), $message);


        return json_encode($data);
    }

    public function addMessage($str, $requestMethod)
    {
        //阻擋未登入者
        if (!isset($_SESSION['userID']) || $requestMethod != 'POST') {
            return false;
        }

        $jsonObj = json_decode($str);
        $message = new Message();
        $message->setBoardID($jsonObj->boardID);
        $message->setMessage($jsonObj->message);

        return MessageService::getDAO()->insertMessage(
            $message->getBoardID(),
            $_SESSION['userID'],
            $message->getMessage()
        );
    }

    //取得所有公開版
    public function getPublicBoard()
    {
        return json_encode(BoardService::getDAO()->getAllPublic());
    }

    public function getBoardMessages($id)
    {
        return json_encode(MessageService::getDAO()->getAllMessageByBoardID($id));
    }

    public function deleteMessage($id, $requestMethod)
    {
        $messageDAO = MessageService::getDAO();

        if (!isset($_SESSION['empID']) && ($requestMethod != 'DELETE' || $messageDAO->getOneMessageByID($id)->getUserID() != $_SESSION['userID'])) {
            return false;
        }

        //判斷是否為第一個留言，如果是就直接刪除
        if (($boardID = $messageDAO->checkIsBoardByID($id)) == 0) {
            $data['message'] = $id;
            return ($messageDAO->deleteMessageByID($id)) ? json_encode($data) : false;
        }

        $data['board'] = $id;
        //刪除留言板
        return (BoardService::getDAO()->deleteByID($boardID)) ? json_encode($data) : false;
    }

    public function updateMessage($str, $requestMethod)
    {
        $jsonObj = json_decode($str);
        $message = new Message();
        $message->setMessageID($jsonObj->messageID);
        $message->setMessage($jsonObj->message);
        $messageDAO = MessageService::getDAO();

        if (!isset($_SESSION['empID']) && ($requestMethod != 'PUT' || $messageDAO->getOneMessageByID($message->getMessageID())->getUserID() != $_SESSION['userID'])) {
            return false;
        }

        if (!$messageDAO->updateMessage($message)) {
            return false;
        }

        $request = BoardService::getDAO()->getUpdateDateByMessageID($message->getMessageID());

        // $data = array(
        //     'boardID' => $request['boardID'],
        //     'authority' => $request['authority'],
        //     'messageID' => $request['messageID']
        // );
        return json_encode($request);
    }
}
