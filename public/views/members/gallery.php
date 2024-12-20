<?php
require_once '../../../Db.php';
$db = new Db();
$allRows = $db->getAllRows();
$id = $_GET['id'];


?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
<div class="container-fluid">

    <div class="text-center mt-5 mb-3">
        <h1 class="fw-bolder lh-sm fs-1 text " style="max-width: 1000px; margin: 0 auto;">
            Галерея спогадів
        </h1>
    </div>

    <div class="container mt-4">

        <div class="btn-group mt-5">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    data-bs-auto-close="inside" aria-expanded="false">
                Додати спогад
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/views/members/formcardgallery.php?id=<?=$id ?>">Фото</a></li>

                <li><a class="dropdown-item" href="#">Текс</a></li>
            </ul>
        </div>

        <div class="card-group mt-5">
            <div class="card">
                <img src="/img/67643e7b86dba-ба.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">This is a wider card with supporting text below as a natural lead-in to
                        additional content. This content is a little bit longer.</p>
                    <p class="card-text"><small class="text-body-secondary">Last updated 3 mins ago</small></p>
                </div>
            </div>
        </div>

        <div class="card" style="margin-top: 50px">
            <div class="card-body">
                This is some text within a card body.
            </div>
        </div>


        <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primary btn-lg" href="/">
            Повернутись на головну
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/main.js"></script>
</body>
</html>