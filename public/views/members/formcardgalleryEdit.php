<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use FamilyTree\Db;

if (empty($_GET['id'])) {
    header('Location: /');
}

$id = $_GET['id'];
$db = Db::getInstance();
$card = $db->getCardById($id);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Cormorant+Unicase:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 mt-5 mb-5">
            <h1 class="text-center mt-2 mb-4 t-h1">Форма редагування картки спогадів </h1>

            <form action="/controllers/GalleryController.php?action=updateCard" method="POST" class="d-block p-2"
                  enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                <input type="hidden" name="family_member_id" value="<?= $card['family_member_id'] ?>">
                <input type="hidden" name="current_image_path" value="<?= htmlspecialchars($card['image_path']) ?>">

                <div class="mb-3">
                    <div class="mb-3">
                        <label for="image" class="form-label">Поточна фотографія</label>

                        <?php if (!empty($card['image_path'])): ?>
                            <img src="<?= htmlspecialchars($card['image_path']) ?>" alt="Фото"
                                 style="max-width: 100px; max-height: 100px; object-fit: contain;">
                        <?php else: ?>
                            <span>Фотографія відсутня</span>
                        <?php endif; ?>

                        <label class="form-label">Завантажити нову фотографію:</label>
                        <input type="file" class="form-control" name="image" id="image"
                               accept="image/png, image/jpeg">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="title" class="form-label">Заголовок:</label>
                    <input type="text" value="<?= $card['title'] ?>" name="title" id="title" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Опис:</label>
                    <textarea name="description" id="description"
                              class="form-control" rows="4"><?= $card['description'] ?></textarea>
                </div>

                <button type="submit" class=" d-grid gap-2 col-6 mx-auto mt-3 btn btn-primar">Оновити картку</button>
            </form>
        </div>
    </div>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/jquery.min.js"></script>
</body>
</html>