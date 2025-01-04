<?php

use FamilyTree\helpers\GenerateTreeHelper;

require_once __DIR__ . '/../../../vendor/autoload.php';
session_start();

//$_SESSION['user_id'] = 35;

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
            <h1 class="text-center fs-4 mt-2 mb-4 text-primary">Авторизація</h1>

            <form action="/controllers/AuthController.php?action=createUser" method="POST" class="form-control d-block p-2">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Прізвище" aria-label="First name">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="По-батькові" aria-label="Last name">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" id="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Пароль:</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Створити користувача</button>
            </form>
        </div>
    </div>
</div>
<body>


<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
