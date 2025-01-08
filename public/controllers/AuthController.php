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

}

$controller = new AuthController();
$controller->runAction($_GET['action'] ?? '');