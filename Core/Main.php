<?php

namespace RBCalendar\Core;

use RBCalendar\Controllers\MainController;

setlocale(LC_TIME, ['fr', 'fra', 'fr_FR']);
session_start();

/**
 * Routeur principal
 */
class Main
{
    public function start()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if (!empty($uri) && $uri != '/' && $uri[-1] === "/") {
            $uri = substr($uri, 0, -1);
            http_response_code(301);
            header('Location: ' . $uri);
            exit;
        }
        $params = explode('/', $_GET['p']);
        if ($params[0] != '') {
            $controller = '\\RBCalendar\\Controllers\\' . ucfirst(array_shift($params)) . 'Controller';
            $fichier = '..' . $controller . '.php';
            if (file_exists($fichier)) {
                $controller = new $controller();
                $action = (isset($params[0])) ? array_shift($params) : 'index';
                if (method_exists($controller, $action)) {
                    (isset($params[0])) ? call_user_func_array([$controller, $action], $params) : $controller->$action();
                } else {
                    $controller = new MainController();
                    $controller->error404();
                }
            } else {
                $controller = new MainController();
                $controller->index();
            }
        } else {
            $controller = new MainController();
            $controller->index();
        }
    }
}
