<?php
include_once APP_DIR.'Controllers/MainController.php';

$url = parse_url($_SERVER['REQUEST_URI']);
$page = $url["path"];

switch ($page){
    case '/':
        (new \Controllers\MainController())->index();
        break;
    case '/edit-comment':
        (new \Controllers\MainController())->editComment();
        break;
    case '/delete-comment':
        (new \Controllers\MainController())->deleteComment();
        break;
    case '/show-answers':
        (new \Controllers\MainController())->showAllAnswers();
        break;
    case '/add-answer':
        (new \Controllers\MainController())->AddAnswer();
        break;
    case '/login':
        (new \Controllers\AuthController())->login();
        break;
    case '/logout':
        (new \Controllers\AuthController())->logout();
        break;
    case '/registration':
        (new \Controllers\AuthController())->registration();
        break;
    default:
        echo '404';
        header("HTTP/1.0 404 Not Found");
        exit();
}