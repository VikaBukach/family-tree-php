<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use FamilyTree\Db;

if (empty($_GET['id'])) {
    header('Location: /');
}

$id = $_GET['id'];
$db = Db::getInstance();

$family_members = $db->getAllRows();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Cormorant+Unicase:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 mt-5 mb-5">
            <h1 class="text-center mt-2 mb-4 t-h1">Форма додавання картки спогадів </h1>

            <form action="/controllers/GalleryController.php?action=insertCard" method="POST" class="d-block p-2" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="hidden" name="family_member_id" value="<?= $id ?>">
                    <label for="image" class="form-label">Зображення:</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg">
                    <input type="hidden" name="image_path" value="">
                </div>

                <!--для вибору людей на фотографії -->
                <div class="mb-3">
                    <label for="members">Люди на фотографії:</label>
                    <select name="family_members[]" id="members" multiple>
                        <?php foreach ($family_members as $member): ?>
                             <option value="<?= $member['id'] ?>"><?= $member['name'] ?> <?= $member['surname'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Заголовок:</label>
                    <input type="text" name="title" id="title" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Опис:</label>
                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                </div>

                <button type="submit" class=" d-grid gap-2 col-6 mx-auto mt-3 btn btn-primar">Створити картку</button>
            </form>
        </div>
    </div>

    <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primar btn-lg" href="/views/members/gallery.php?id=<?= $id ?>">
        Повернутись до галереї спогадів
    </a>
    <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primar btn-lg" href="/">
        Повернутись на головну
    </a>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/jquery.min.js"></script>
</body>
</html>