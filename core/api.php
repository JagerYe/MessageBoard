<?php

class Api
{
    public function __construct()
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $url = rtrim($_GET["url"], "/");
        $url = explode("/", $url);
        $controllerName = "{$url[0]}Controller";
        if (!file_exists("{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/controllers/$controllerName.php")) {
            return;
        }
        require_once "{$_SERVER['DOCUMENT_ROOT']}/MessageBoard/controllers/$controllerName.php";
        $controller = new $controllerName;
        $methodName = isset($url[1]) ? $url[1] : "";
        if (!method_exists($controller, $methodName)) {
            return;
        }
        switch ($requestMethod) {
            case 'GET':
                $values = array_values($_GET);
                unset($values[0]);
                break;
            case 'POST':
                $values = array_values($_POST);
                break;
            case 'PUT':
            case 'DELETE':
                parse_str(file_get_contents('php://input'), $values);
                break;
        }
        $values[] = $requestMethod;

        echo call_user_func_array(array($controller, $methodName), $values);
    }
}
