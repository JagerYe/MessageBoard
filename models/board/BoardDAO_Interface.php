<?php
interface BoardDAO
{
    public function insertBoard($userID, $authority, $message);
    public function updateBoard($board);
    public function getOneBoardByID($id);
    public function getAllUserBoardByUserID($id);
}
