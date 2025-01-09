<?php

use FamilyTree\helpers\GenerateTreeHelper;

require_once __DIR__ . '/../../../vendor/autoload.php';
session_start();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap" rel="stylesheet">

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
    <title>Family tree</title>
</head>
<div class="container-fluid ">
    <div class="row justify-content-center login-form">
        <div class="col-xl-6 col-lg-6 mt-5 mb-5 login-content">
            <h1 class="text-center fs-4 mt-2 mb-4 brand-text">Authorization</h1>

            <form action="/controllers/AuthController.php?action=loginUser" method="POST" class="form-control d-block p-2">
                <div class="row" style="margin-top: 20px;">
                    <div class="col">
                        <input type="text" name="login" class="form-control" placeholder="Логін" aria-label="login">
                    </div>
                    <div class="col">
                        <input type="password" name="password" class="form-control" placeholder="Пароль" id="password">
                    </div>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto mt-3">
                    <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Увійти</button>
                </div>
            </form>
                <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-primary " href="/views/auth/auth.php">Зареєструватися</a>
        </div>
    </div>
</div>
<body>


<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>

