<?php
class MessageController extends Controller
{
    public function __construct()
    {
        $this->requireDAO("Board");
        $this->requireDAO("Message");
    }

    public function addMainMessage($str)
    {
        $jsonArr = json_decode($str);
        // $board = $jsonArr['board'];
        $board = new Board();
        $board->setAuthority($jsonArr->board->authority);

        $message = new Message();
        $message->setMessage($jsonArr->message->message);
        $data = BoardService::getDAO()->insertBoard($_SESSION['userID'], $board->getAuthority(), $message);


        return json_encode($data);
    }

    public function addMessage($str)
    {
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

    public function getPublicBoard()
    {
        return json_encode(BoardService::getDAO()->getAllPublic());
    }

    public function getBoardMessages($id, $authority)
    {
        return json_encode(MessageService::getDAO()->getAllMessageByBoardID($id));
    }

    public function deleteMessage($id)
    {
        $messageDAO = MessageService::getDAO();

        //判斷是否為第一個留言，如果是就直接刪除
        if (($boardID = $messageDAO->checkIsBoardByID($id)) == 0) {
            $data['message'] = $id;
            return ($messageDAO->deleteMessageByID($id)) ? json_encode($data) : false;
        }

        $data['board'] = $boardID;
        //刪除留言板
        return (BoardService::getDAO()->deleteByID($boardID)) ? json_encode($data) : false;
    }

    public function updateMessage($str)
    {
        $jsonObj = json_decode($str);
        $message = new Message();
        $message->setMessageID($jsonObj->messageID);
        $message->setMessage($jsonObj->message);

        return MessageService::getDAO()->updateMessage($message);
    }
}
