<?php
//don't display errors
ini_set('display_errors', 0);
//write errors to log
ini_set('log_errors', 1);
error_reporting(E_ALL & ~E_NOTICE);

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/pages/';

switch ($request) 
{
    case '':
    case '/':
        echo "hello";
        // require __DIR__ . $viewDir . 'home.php';
        break;

    case '/pages/users':
        // require __DIR__ . $viewDir . 'users.php';
        break;

    case '/contact':
        // require __DIR__ . $viewDir . 'contact.php';
        break;

    default:
        http_response_code(404);
        $errorPageUrl = "https://http.cat/404";
        header("Location: $errorPageUrl");
        exit;
}