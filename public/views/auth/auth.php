<?php

require_once __DIR__ . '/../../../vendor/autoload.php';
session_start();

if (isset($_GET['error']) && $_GET['error'] === 'auth_exists') {
    echo "<p style='color: red;'>Цей логін вже використовується. Будь ласка, виберіть інший.</p>";
}

if (isset($_GET['success']) && $_GET['success'] === 'registered') {
    echo "<p style='color: green;'>Реєстрація успішна. Увійдіть у систему.</p>";
}
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
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 mt-5 mb-5">
            <h1 class="text-center fs-4 mt-2 mb-4 text-primary">Реєстрація користувача</h1>

            <form action="/controllers/AuthController.php?action=createUser" method="POST"
                  class="form-control d-block p-2">
                <div class="row">
                    <div class="col">
                        <input type="text" name="surname" class="form-control" placeholder="Прізвище" aria-label="surname">
                    </div>
                    <div class="col">
                        <input type="text" name="name" class="form-control" placeholder="Імʼя" aria-label="name">
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col">
                        <input type="text" name="login" class="form-control" placeholder="Логін" aria-label="login">
                    </div>
                    <div class="col">
                        <input type="password" name="password" class="form-control" placeholder="Пароль" id="password">
                    </div>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto mt-3">
                    <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Зареєструватися</button>
                </div>
            </form>
        </div>
    </div>
</div>
<body>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
