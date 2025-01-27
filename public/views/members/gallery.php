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
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Cormorant+Unicase:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">

</head>
<body>
<div class="container-fluid">

    <div class="text-center mt-5 mb-3">
        <h1 class="text-center mb-4 mt-4" style="max-width: 1000px; margin: 0 auto;">
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
                <!------------------створення карточки---img-object-fit: cover------------------>
                <div class="card"
                     style="width: 400px; height: 500px; border: 1px solid #8b7e4e; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column;">
                    <div style="width: 100%; height: 75%; display: flex; justify-content: center; align-items: center;">
                        <?php if (!empty ($card['image_path'])) : ?>
                            <img src="<?= htmlspecialchars($card['image_path']) ?>" class="card-img-top" alt="фото"
                                 style="max-width: 100%; max-height: 100%; object-fit: contain;">
                        <?php else: ?>
                            <span>Відсутне фото</span>
                        <?php endif; ?>
                    </div>
                    <div class="card-body"
                         style="padding: 10px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <h5 class="card-title"
                            style="font-size: 18px; margin-bottom: 5px; text-align: center;"><?= $card['title'] ?></h5>
                        <p class="card-text"
                           style="font-size: 16px; color: #555; text-align: center;"><?= $card['description'] ?></p>
                    </div>

                    <div style="display: flex; justify-content: space-between">
                        <!-- Edit иконка -->
                        <a href="/views/members/formcardgalleryEdit.php?id=<?= $card['id'] ?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2e2e2e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20.24 4.24a2.5 2.5 0 0 0-3.54 0L9 11.93V15h3.07l7.7-7.7a2.5 2.5 0 0 0 0-3.54z"></path>
                                <path d="M7 20h10"></path>
                                <path d="M16 8L9 15"></path>
                            </svg>
                            <span style="margin-left: 5px;">Редагувати</span>
                        </a>

                    <!-- Delete иконка -->
                    <form action="/controllers/GalleryController.php?action=deleteCard" method="POST">
                        <input type="hidden" name="id" value="<?= $card['id'] ?>">
                        <button type="submit" style="background: none; border: none; cursor: pointer; display: flex; align-items: center;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#2e2e2e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="3 6 5 6 21 6"></polyline>
                                <path d="M19 6l-2 14a2 2 0 0 1-2 2H9a2 2 0 0 1-2-2L5 6"></path>
                                <path d="M10 11v6"></path>
                                <path d="M14 11v6"></path>
                            </svg>
                            <span style="margin-left: 5px;">Видалити</span>

                        </button>
                    </form>


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
            <div class="card-body" style="font-size: 18px;"><?= $familyMember['history'] ?></div>
        </div>

        <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primar btn-lg"
           href="/views/members/relationsform.php?id=<?= $id ?>">
            Додати звʼязок з родиною
        </a>

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
