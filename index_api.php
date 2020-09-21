<?php
session_start();
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/core/api.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/core/Controller.php";
require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/core/smartyConfig.php";

$api = new Api();
