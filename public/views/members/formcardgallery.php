<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use FamilyTree\Db;

if (empty($_GET['id'])) {
    header('Location: /');
}

$id = $_GET['id'];
$db = new Db();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 mt-5 mb-5">
            <h1 class="text-center fs-4 mt-2 mb-4 text-primary">Форма додавання картки спогадів </h1>

            <form action="/controllers/GalleryController.php?action=createCard" method="POST" class="d-block p-2" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="hidden" name="family_member_id" value="<?= $id ?>">
                    <label for="image" class="form-label">Зображення:</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg">
                    <input type="hidden" name="image_path" value="">
                    <!-- Тут зберігається шлях до фото -->
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Заголовок:</label>
                    <input type="text" name="title" id="title" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Опис:</label>
                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Створити картку</button>
            </form>
        </div>
    </div>

    <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primary btn-lg" href="/projects/family-tree-php/public/views/members/gallery.php">
        Повернутись на головну
    </a>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/jquery.min.js"></script>
</body>
</html>