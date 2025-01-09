<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use FamilyTree\Db;

if (empty($_GET['id'])) {
    header('Location: /');
}

$id = $_GET['id'] ?? '';

$db = Db::getInstance();
$familyMember = $db->getMemberById($id);
$memberCards = $db->getAllCardByIdMember($id);

//var_dump($familyMember);

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

    <div class="text-center mt-5 mb-3">
        <h1 class="text-center mt-2 mb-4 t-h1" style="max-width: 1000px; margin: 0 auto;">
            Галерея спогадів
        </h1>
    </div>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center">
            <div class="btn-group mt-5">
                <button class="btn btn-primar dropdown-toggle" style="margin-bottom: 30px;" type="button"
                        data-bs-toggle="dropdown"
                        data-bs-auto-close="inside" aria-expanded="false">
                    Додати спогад
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/views/members/formcardgallery.php?id=<?= $id ?>">Фото</a></li>
                    <!--                <li><a class="dropdown-item" href="#">Текс</a></li>-->
                </ul>
            </div>

            <a href="/views/members/connections.php?id=<?= $id ?>" class="btn btn-primar">Родинні звʼязки</a>
        </div>


        <div class="card-container" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
            <?php foreach ($memberCards as $card) : ?>
                <!------------------створення карточки---------------------->
                <div class="card"
                     style="width: 400px; height: 500px; border: 1px solid #8b7e4e; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="width: 100%; height: 75%; display: flex; justify-content: center; align-items: center; background-color: #f9f9f9;">
                        <?php if (!empty ($card['image_path'])) : ?>
                            <img src="<?= htmlspecialchars($card['image_path']) ?>" class="card-img-top" alt="фото"
                                 style="max-width: 100%; max-height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <span>Відсутне фото</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body" style="padding: 15px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <h5 class="card-title" style="font-size: 18px; margin-bottom: 10px; text-align: center;"><?= $card['title'] ?></h5>
                        <p class="card-text" style="font-size: 14px; color: #555; text-align: center;"><?= $card['description'] ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!--Модальне віккно для перегляду збільшенного зображення -->
        <div id="imageModal"
             style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.8); justify-content: center; align-items: center; z-index: 1000;">
            <img id="modalImage" src="" alt="Зображення"
                 style="max-width: 90%; max-height: 90%; border: 5px solid white; border-radius: 8px;">
        </div>
        <!------------------створення біографіі(виводиться з дискрипшина) ---------------------->
        <div class="card" style="margin-top: 50px; margin-bottom: 50px; border: 1px solid #8b7e4e">
            <div class="card-body"><?= $familyMember['history'] ?></div>
        </div>

        <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primar btn-lg" href="/" style="margin-bottom: 30px;">
            Повернутись на головну
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            const $modal = $('#imageModal');
            const $modalImage = $('#modalImage');

            //open modal on click
            $('.card-img-top').on('click', function () {
                const src = $(this).attr('src');   //отримуємо джерело зображ
                $modalImage.attr('src', src);      // устанавлюємо джерело у модальне вікно
                $modal.css('display', 'flex');
            });

            //Закриття мод вікна при клік
            $modal.on('click', function () {
                $modal.css('display', 'none');
            })
        })
    </script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery.min.js"></script>
</body>
</html>
