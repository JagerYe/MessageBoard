<?php
class TransactionRecordController extends Controller
{
    private $_dao;
    public function __construct()
    {
        $this->requireDAO("transactionRecord");
    }

    public function insertByObj($str)
    {
        if (!($record = $this->getJsonToModel("transactionRecord", $str, true))) {
            return false;
        }

        if (TransactionRecordService::getDAO()->insertTransactionRecordByObj($record)) {
            return true;
        }

        return false;
    }

    public function update($str)
    {
        if (!($record = $this->getJsonToModel("transactionRecord", $str))) {
            return false;
        }

        if ($id = TransactionRecordService::getDAO()->updateTransactionRecord($record)) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        if (TransactionRecordService::getDAO()->deleteTransactionRecordByID($id)) {
            return true;
        }
        return false;
    }

    public function getAll($userUTC)
    {

        if ($records = TransactionRecordService::getDAO()->getAllTransactionRecords()) {
            return json_encode($records);
        }
        return false;
    }

    public function getOne($userUTC, $id)
    {
        if ($record = TransactionRecordService::getDAO()->getOneTransactionRecordByID($id)) {
            return json_encode($record);
        }
        return false;
    }

    public function getUserTransactionRecords($id)
    {
        if (!isset($_SESSION['userID'])) {
            return false;
        }
        if ($records = TransactionRecordService::getDAO()->getTransactionRecordByUserID($id)) {
            return json_encode($records);
        }
        return false;
    }

    public function getUserBalance()
    {
        if ($balance = TransactionRecordService::getDAO()->getUserBalance($_SESSION["userID"])) {
            $i = strlen($balance);
            return json_encode($balance);
        }
        return false;
    }

    public function getUserHistoricalRecord()
    {
        if ($records = TransactionRecordService::getDAO()->getUserHistoricalRecord($_SESSION['userID'])) {
            return json_encode($records);
        }
        return false;
    }
}
