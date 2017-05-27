<?php
namespace Controllers;


use Helpers\DbHelper;
use Models\Comment;
use Models\User;

class MainController
{

    public function index(){
//POST запросы
        //Создание нового комментария
        if(isset($_POST['text']) && isset($_SESSION['user'])) {
            if ($user_id = unserialize($_SESSION['user'])->getId()) {
                (new DbHelper())->insertComment(new Comment(['text'=>$_POST['text'], 'user_id'=>$user_id]), $_SESSION['comment_id']??0);
            }
        }
        //Ajax-подгрузка комментариев при прокрутке страницы
        elseif(isset($_POST['startFrom'])){
            echo json_encode((new DbHelper())->getComments(null,null,10,$_POST['startFrom']));
            exit();
        }

//Вывод списка комментариев
        return view ('comments',[
            'comments'=>(new DbHelper())->getComments(null,null,10)
        ]);
    }

    public function editComment()
    {
        if(empty($_POST))
            return header('Location: /');

        if(isset($_POST['newText']) && isset($_POST['commentId'])){
            if((new DbHelper())->updateComment(new Comment(['text'=>$_POST['newText'], 'id'=>(int)$_POST['commentId']]))){
                echo $_POST['newText'];
                exit();
            }
        }
        header("HTTP/1.0 400 Bad Request");
        exit();
    }

    public function deleteComment()
    {
        if(empty($_POST))
            return header('Location: /');

        if(isset($_POST['commentId'])){
            if((new DbHelper())->deleteComment((int)$_POST['commentId'])){
                echo $_POST['commentId'];
                exit();
            }
        }
        header("HTTP/1.0 400 Bad Request");
        exit();
    }

//Ajax-подгрузка ответов к комментарию
    public function showAllAnswers(){
        if(empty($_POST))
            return header('Location: /');

        if(isset($_POST['commentId']) && isset($_POST['commentCount'])){
            echo json_encode((new DbHelper())->getComments(null, $_POST['commentId'], $_POST['commentCount'], 2));
            exit();
        }
        header("HTTP/1.0 400 Bad Request");
        exit();
    }

    public function AddAnswer()
    {
        if(empty($_POST))
            return header('Location: /');

        if(isset($_POST['commentId']) && isset($_POST['commenText'])){
            if ($user_id = unserialize($_SESSION['user'])->getId()) {
                echo json_encode((new DbHelper())->insertComment(new Comment(['text'=>$_POST['commenText'], 'user_id'=>$user_id]), $_SESSION['commentId']));
                exit();
            }
        }
        header("HTTP/1.0 400 Bad Request");
        exit();
    }

}