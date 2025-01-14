<?php

require_once __DIR__. '/../../vendor/autoload.php';

use FamilyTree\BaseController;
class AuthController extends BaseController
{

    public function actionCreateUser()
    {
        if($_POST){
            $surname = trim($_POST['surname'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $login = trim($_POST['login'] ?? '');
            $password = trim($_POST['password']);

            if(empty($surname) || empty($name) || empty($login) ||empty($password)){
                die('Всі поля обовʼязкові до заповнення');
            }

            $this->db->createUser($surname, $name, $login, $password);
        }
    }

    public function actionLoginUser()
    {
        if($_POST){

            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';

            if(empty($login) || empty($password)){
                die('Заповніть логін та пароль');
            }
            try {
                $user = $this->db->loginUser($login, $password);

                //починаємо сессію і зберігаємо користувача
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                header('Location: /');
            }catch (Exception $exception){
                die($exception->getMessage());
            }
        }
    }

}

$controller = new AuthController();
$controller->runAction($_GET['action'] ?? '');

