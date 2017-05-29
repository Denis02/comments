<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 26.05.17
 * Time: 23:57
 */

namespace Helpers;


use Models\Comment;
use Models\User;
use PDO;

class DbHelper
{
    private $db;

    public function __construct()
    {
        /* Подключение к БД */
        $config = dbConfig();
        $this->db = new PDO($config['dsn'], $config['user'], $config['pass']);
    }


////Запросы к таблице "users"

    /*Регистрация пользователя*/
    public function registerUser($email, $password, $name)
    {
        $password = crypt($password, $email);
        $email = strtolower($email);
        //если запись прошла успешно вернуть "true"
        if($this->db->query("INSERT INTO users (email,password,name) VALUES ('$email','$password','$name')")){
            return true;
        }
        return false;
    }

    /*Авторизация пользователя*/
    public function loginUser($email, $password)
    {
        $password = crypt($password, $email);
        $email = strtolower($email);
        //если запрос прошел успешно вернуть объект User
        if($user = $this->db->query("SELECT * FROM users WHERE email='$email' AND password = '$password' LIMIT 1")->fetch()){
            return new User($user);
        }
        return false;
    }

    /*Получение пользователя по 'id'*/
    public function getUserById($id){
        //если запрос прошел успешно вернуть объект User
        if($user = $this->db->query("SELECT * FROM users WHERE id=$id LIMIT 1")->fetch()){
            return new User($user);
        }
        return false;
    }


////Запросы к таблице "comments"

    /*Получение комментария по 'id'*/
    public function getCommentById($id){
        //если запрос прошел успешно вернуть объект Comment
        if($user = $this->db->query("SELECT * FROM comments WHERE id=$id LIMIT 1")->fetch()){
            return new Comment($user);
        }
        return false;
    }

    /*Получение списка комментариев*/
    public function getComments(int $user_id=null, int $comment_id=null, int $count=15, int $start=0, string $sort='created_at')
    {
        // получение количества записей в таблице
        $rows = $this->getCountComments($user_id,$comment_id);
        $comments = [];
        // получение записей из таблицы если количество записей больше 0
        if($rows > 0) {
            if ($user_id) {
                // получение комментариев конкретного пользователя
                $items = $this->db->query("SELECT * FROM comments WHERE (user_id=$user_id) ORDER BY $sort DESC  LIMIT $start, $count")->fetchAll();
            } else if ($comment_id) {
                // получение вложенных комментариев конкретного комментария
                $items = $this->db->query("SELECT * FROM comments WHERE (comment_id=$comment_id) ORDER BY created_at DESC LIMIT $start, $count")->fetchAll();
            } else {
                // получение комментариев всех пользователей и не являющихся вложенными
                $items = $this->db->query("SELECT * FROM comments WHERE (comment_id=0) ORDER BY $sort DESC  LIMIT $start, $count")->fetchAll();
            }
            // возвращает массив обЪектов класса Comment
            foreach ($items as $item) {
                $comments[] = new Comment($item);
            }
        }
        return $comments;
    }

    /*Получение количества комментариев*/
    public function getCountComments(int $user_id=null, int $comment_id=null){
        if ($user_id) {
            $rows = $this->db->query("SELECT COUNT(*) as count FROM comments  WHERE (user_id=$user_id)")->fetchColumn();
        } else if ($comment_id) {
            $rows = $this->db->query("SELECT COUNT(*) as count FROM comments WHERE (comment_id=$comment_id)")->fetchColumn();
        } else {
            $rows = $this->db->query("SELECT COUNT(*) as count FROM comments WHERE (comment_id=0 )")->fetchColumn();
        }
        return $rows;
    }

    /*Запись нового комментария*/
    public function insertComment(Comment $comment, int $comment_id=0){
        if(empty($comment->user->getId()) || empty($comment->text))
            return false;
        $created_at = date('Y-m-d H:i:s');
        //если запрос прошел успешно вернуть 'id' созданного комментария
        if($res=$this->db->query("INSERT INTO comments 
                  (text,user_id,comment_id,created_at) VALUES (
                  '{$comment->text}',
                  '{$comment->user->getId()}',
                  '$comment_id',
                  '$created_at'
                  )")){
            return $this->db->lastInsertId();
        }
        return false;
    }

    /*Обновление комментария*/
    public function updateComment(Comment $comment){
        if(empty($comment->id) || empty($comment->text))
            return false;
        $updated_at = date('Y-m-d H:i:s');
        //если запрос прошел успешно вернуть 'true'
        if($this->db->query("UPDATE comments SET 
                  text = '{$comment->text}',
                  updated_at = '$updated_at'
                  WHERE id = {$comment->id}")){
            return true;
        }
        return false;
    }

    /*Удаление комментария*/
    public function deleteComment(int $id){
        //удаление вложенных комментариев и оценок удаляемого комментария
        $this->db->query("DELETE FROM comments WHERE comment_id = $id");
        $this->db->query("DELETE FROM appraisals WHERE comment_id = $id");
        //если запрос прошел успешно вернуть 'true'
        if($this->db->query("DELETE FROM comments WHERE id = $id")){
            return true;
        }
        return false;
    }


////Запросы к таблице "appraisals"

    /*Получение оценок комментария*/
    public function getRatingComment(int $comment_id=0){
        $rating = [
            'plus'=>[],
            'minus'=>[]
        ];
        $items = $this->db->query("SELECT * FROM appraisals WHERE (comment_id=$comment_id)")->fetchAll();
        //формирование массива со списками 'id' пользьзователей оценивших данный комментарий
        foreach ($items as $item) {
            if ($item['value'])
                $rating['plus'][] = $item['user_id'];
            else
                $rating['minus'][] = $item['user_id'];
        }
        return $rating;
    }

    /*Запись оценки комментария*/
    public function insertAppraisal(int $comment_id, int $user_id, $value)
    {
        //если запрос прошел успешно вернуть 'true', таблица содержит двоичный ключ (comment_id,user_id)
        if($this->db->query("INSERT INTO appraisals (comment_id,user_id,value) VALUES ($comment_id,$user_id,$value)")){
            return true;
        }
        return false;
    }

}