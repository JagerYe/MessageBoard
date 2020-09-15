<?php
class MessageController extends Controller
{
    public function __construct()
    {
        $this->requireDAO("Board");
        require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/message/Message.php";
    }

    public function addMainMessage($str)
    {
        $jsonArr = json_decode($str);
        // $board = $jsonArr['board'];
        $board = new Board();
        $board->setAuthority($jsonArr->board->authority);

        $message = new Message();
        $message->setMessage($jsonArr->message->message);

        return BoardService::getDAO()->insertBoard($_SESSION['userID'], $board->getAuthority(), $message);
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
}
