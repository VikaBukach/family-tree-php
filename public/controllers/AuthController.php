<?php

require_once __DIR__. '/../../vendor/autoload.php';

use FamilyTree\BaseController;
class AuthController extends BaseController
{

    public function actionCreateUser()
    {
        session_start(); // Ініціалізація сесії

        if($_POST){
            $surname = trim($_POST['surname'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $login = trim($_POST['login'] ?? '');
            $password = trim($_POST['password']);

            if (empty($surname) || empty($name) || empty($login) || empty($password)) {
                $_SESSION['error_message'] = 'Всі поля обовʼязкові до заповнення.';
                header('Location: /views/auth/auth.php');
                exit;
            }

            //перевірка наявності у табл family_members
            $familyMember = $this->db->checkFamilyMember($surname, $name);

            if(!$familyMember){
                $_SESSION['error_message'] = 'Відмовлено в доступі';
                header('Location: /views/auth/auth.php');
                exit;
            }

            $this->db->createUser($surname, $name, $login, $password, $familyMember['id']);

            // Успішна реєстрація
            $_SESSION['success_message'] = 'Реєстрація успішна. Увійдіть у систему.';
            header('Location: /views/auth/login.php');
            exit;
        }
    }

    public function actionLoginUser()
    {
        session_start();

        if($_POST){
            $login = $_POST['login'] ?? '';
            $password = $_POST['password'] ?? '';

            if(empty($login) || empty($password)){
                $_SESSION['error_message'] = 'Заповніть логін та пароль.';
                header('Location: /views/auth/login.php');
                exit;
            }

            try {
                // Авторизація користувача
                $user = $this->db->loginUser($login, $password);

                // Перевірка, чи користувач знайдений
                if (!$user) {
                    $_SESSION['error_message'] = 'Неправильний логін або пароль.';
                    header('Location: /views/auth/login.php'); // Перенаправлення назад
                    exit;
                }

                // Збереження даних у сесію
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                header('Location: /');

            }catch (Exception $exception){
                // Збереження помилки в сесії та перенаправлення назад
                $_SESSION['error_message'] = 'Помилка входу: ' . $exception->getMessage();
                header('Location: /views/auth/login.php');
                exit;
            }
        }
    }

}

$controller = new AuthController();
$controller->runAction($_GET['action'] ?? '');

