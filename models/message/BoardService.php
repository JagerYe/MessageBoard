<?php

require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/models/board/BoardDAO_PDO.php";
class BoardService
{
    public static function getDAO()
    {
        return new BoardDAO_PDO();
    }
}
