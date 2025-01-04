<?php

require_once __DIR__. '/../../vendor/autoload.php';

use FamilyTree\BaseController;
class AuthController extends BaseController
{

    public function actionCreateUser()
    {
        if($_POST){
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $this->db->createUser($email, $password);
        }
    }

}

$controller = new AuthController();
$controller->runAction($_GET['action'] ?? '');