<?php

require_once __DIR__. '/../../vendor/autoload.php';

use FamilyTree\BaseController;
class AuthController extends BaseController
{

    public function actionCreateUser()
    {
        if($_POST){
            $username = trim($_POST['username'] ?? '');
            $userlastname = trim($_POST['userlastname'] ?? '');
            $login = trim($_POST['login'] ?? '');
            $password = trim(password_hash($_POST['password'], PASSWORD_BCRYPT));

            if(empty($username) || empty($userlastname) || empty($login) ||empty($password)){
                die('Всі поля обовʼязкові до заповнення');
            }

            $this->db->createUser($username, $userlastname, $login, $password);
        }
    }

}

$controller = new AuthController();
$controller->runAction($_GET['action'] ?? '');