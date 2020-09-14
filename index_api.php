<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/core/api.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/core/Controller.php";

try {
    $api = new Api();
} catch (Exception $err) {
    return false;
}
