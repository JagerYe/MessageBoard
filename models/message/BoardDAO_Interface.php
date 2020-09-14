<?php
interface BoardDAO
{
    public function insertBoard($userID, $authority);
    public function updateBoard($board);
    public function getOneBoardByID($id);
    public function getAllUserBoardByUserID($id);
}
