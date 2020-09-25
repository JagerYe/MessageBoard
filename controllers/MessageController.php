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
        $json = json_decode($str);

        //阻擋未登入者
        if (!isset($_SESSION['userID']) || $requestMethod != 'POST' || $_SESSION['userID'] !== $json->userID) {
            return 'false';
        }

        // $board = $json['board'];
        $board = new Board();
        $board->setAuthority($json->board->authority);

        $message = new Message();
        $message->setMessage($json->message->message);

        return json_encode(BoardService::getDAO()->insertBoard($_SESSION['userID'], $board->getAuthority(), $message));
    }

    public function addMessage($str, $requestMethod)
    {
        $json = json_decode($str);

        //阻擋未登入者
        if (!isset($_SESSION['userID']) || $requestMethod != 'POST' || $_SESSION['userID'] !== $json->userID) {
            return 'false';
        }


        $message = new Message();
        $message->setBoardID($json->boardID);
        $message->setMessage($json->message);

        return MessageService::getDAO()->insertMessage(
            $message->getBoardID(),
            $_SESSION['userID'],
            $message->getMessage()
        );
    }

    //取得所有公開版
    public function getAllPublicBoard()
    {
        return json_encode(BoardService::getDAO()->getAllPublic());
    }

    public function getSomePublicBoards($id)
    {
        $id = ($id < 0) ? null : $id;
        return json_encode(BoardService::getDAO()->getSomePublic($id));
    }

    public function getBoardMessages($id)
    {
        return json_encode(MessageService::getDAO()->getAllMessageByBoardID($id));
    }

    public function getSomeBoardMessages($boardID, $startMessageID = -1)
    {
        $messageDAO = MessageService::getDAO();
        $request = $messageDAO->getSomeMessageByBordID($boardID, $startMessageID);
        $request['bothEnds'] = $messageDAO->getBoardFirstAndLastMessageIDByBoardID($boardID);
        return json_encode($request);
    }

    public function deleteMessage($id, $requestMethod)
    {
        $messageDAO = MessageService::getDAO();

        if (!isset($_SESSION['empID']) && ($requestMethod != 'DELETE' || $messageDAO->getOneMessageByID($id)['userID'] != $_SESSION['userID'])) {
            return false;
        }

        //判斷是否為第一個留言，如果是就直接刪除
        if (($boardID = $messageDAO->checkIsBoardByID($id)) === 'false') {
            $data['message'] = $id;
            return ($messageDAO->deleteMessageByID($id)) ? json_encode($data) : 'false';
        }

        $data['board'] = $id;
        //刪除留言板
        return (BoardService::getDAO()->deleteByID($boardID)) ? json_encode($data) : 'false';
    }

    public function updateMessage($str, $requestMethod)
    {
        $json = json_decode($str);
        $message = new Message();
        $message->setMessageID($json->messageID);
        $message->setMessage($json->message);
        $messageDAO = MessageService::getDAO();

        if (!isset($_SESSION['empID']) && ($requestMethod != 'PUT' || $messageDAO->getOneMessageByID($message->getMessageID())['userID'] !== $_SESSION['userID'])) {
            return false;
        }

        return $messageDAO->updateMessage($message->getMessageID(), $message->getMessage());
    }
}
