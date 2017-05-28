<?php
/**
 * Created by PhpStorm.
 * User: denis
 * Date: 27.05.17
 * Time: 15:32
 */

namespace Controllers;


use Helpers\DbHelper;

class AuthController
{

    /*Регистрация нового пользователя*/
    public function registration(){
        //перенаправление авторизированного пользователя
        if(isset($_SESSION['user']))
            return header('Location: /');
        //POST-запрос
        if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirmation'])){
            if($_POST['password'] == $_POST['password_confirmation']) {
                //если регистрация прошла успешно перенаправить на метод Авторизации
                if ((new DbHelper())->registerUser($_POST['email'], $_POST['password'], $_POST['name'])) {
                    return $this->login();
                }
            }
        }
        //отображение страницы регистрации
        return view ('registration');
    }

    /*Авторизация пользователя*/
    public function login(){
        //перенаправление авторизированного пользователя
        if(isset($_SESSION['user'])) {
            if(isset($_SERVER['HTTP_REFERER']))
                return header('Location: '.$_SERVER['HTTP_REFERER']);
            return header('Location: /');
        }
        //POST-запрос
        if(isset($_POST['email']) && isset($_POST['password'])){
            //если авторизация прошла успешно перенаправить на Главную страницу
            if($user=(new DbHelper())->loginUser($_POST['email'],$_POST['password'])){
                $_SESSION['user'] = serialize($user);
                return header('Location: /');
            }
        }
        //отображение страницы авторизации
        return view ('login');
    }

    /*Разлогинивание пользователя*/
    public function logout(){
        unset($_SESSION['user']);
        if(isset($_SERVER['HTTP_REFERER']))
            return header('Location: '.$_SERVER['HTTP_REFERER']);
        return header('Location: /');
    }

}