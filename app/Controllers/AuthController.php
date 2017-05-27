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

    public function registration(){
        if(isset($_SESSION['user']))
            return header('Location: /');
        //POST запрос
        if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_confirmation'])){
            if($_POST['password'] == $_POST['password_confirmation']) {
                if ((new DbHelper())->registerUser($_POST['email'], $_POST['password'], $_POST['name'])) {
                    return $this->login();
                }
            }
        }

        return view ('registration');
    }

    public function login(){
        if(isset($_SESSION['user'])) {
            if(isset($_SERVER['HTTP_REFERER']))
                return header('Location: '.$_SERVER['HTTP_REFERER']);
            return header('Location: /');
        }
        //POST запрос
        if(isset($_POST['email']) && isset($_POST['password'])){
            if($user=(new DbHelper())->loginUser($_POST['email'],$_POST['password'])){
                $_SESSION['user'] = serialize($user);
                return header('Location: /');
            }
        }
        return view ('login');
    }

    public function logout(){
        //POST запрос
        unset($_SESSION['user']);
        if(isset($_SERVER['HTTP_REFERER']))
            return header('Location: '.$_SERVER['HTTP_REFERER']);
        return header('Location: /');
    }

}