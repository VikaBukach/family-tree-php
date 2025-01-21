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
                    <div class="card-body" style="padding: 15px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
                        <h5 class="card-title" style="font-size: 18px; margin-bottom: 10px; text-align: center;"><?= $card['title'] ?></h5>
                        <p class="card-text" style="font-size: 14px; color: #555; text-align: center;"><?= $card['description'] ?></p>
                    </div>
                    <!-- Edit иконка -->
                    <a href="/views/members/formcardgalleryEdit.php?id=<?= $card['id'] ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="position: absolute; top: 10px; right: 10px; cursor: pointer;">
                            <path d="M0 0h24v24H0z" fill="none"/>
                            <path fill="#2e2e2e" d="M19.707 4.293a1 1 0 0 0-1.414 0L14 8.586 5.414 17.172a1 1 0 0 0-.293.707v2.121a1 1 0 0 0 1 1H8a1 1 0 0 0 .707-.293L16 13.414l4.293-4.293a1 1 0 0 0 0-1.414l-2-2zM14 11.414L12.586 10 15 7.586 16.414 9l-2 2zm-5.293 5L12 9.414 14.586 12 10 16.586 6.707 13z"/>
                        </svg>
<!--                    <svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 55 55" style="position: absolute; top: 7px; right: 40px; cursor: pointer;">-->
<!--                        <path d="M55.736,13.636l-4.368-4.362c-0.451-0.451-1.044-0.677-1.636-0.677c-0.592,0-1.184,0.225-1.635,0.676l-3.494,3.484   l7.639,7.626l3.494-3.483C56.639,15.998,56.639,14.535,55.736,13.636z"/>-->
<!--                        <polygon points="21.922,35.396 29.562,43.023 50.607,22.017 42.967,14.39  "/>-->
<!--                        <polygon points="20.273,37.028 18.642,46.28 27.913,44.654  "/>-->
<!--                        <path d="M41.393,50.403H12.587V21.597h20.329l5.01-5H10.82c-1.779,0-3.234,1.455-3.234,3.234v32.339   c0,1.779,1.455,3.234,3.234,3.234h32.339c1.779,0,3.234-1.455,3.234-3.234V29.049l-5,4.991V50.403z"/>/>-->
<!--                    </svg>-->
                    </a>
                    <!-- Delete иконка -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="position: absolute; top: 10px; right: 40px; cursor: pointer;">
                        <path d="M0 0h24v24H0z" fill="none"/>
                        <path fill="#2e2e2e" d="M19 6h-4V4c0-1.1-.9-2-2-2H9c-1.1 0-2 .9-2 2v2H3c-.55 0-1 .45-1 1v2c0 .55.45 1 1 1h1v10c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V10h1c.55 0 1-.45 1-1V7c0-.55-.45-1-1-1zM9 4h6v2H9V4zm7 16H8V10h8v10zm-5-3c0 .55-.45 1-1 1s-1-.45-1-1V13c0-.55.45-1 1-1s1 .45 1 1v4zm-4 0c0 .55-.45 1-1 1s-1-.45-1-1V13c0-.55.45-1 1-1s1 .45 1 1v4zm8 0c0 .55-.45 1-1 1s-1-.45-1-1V13c0-.55.45-1 1-1s1 .45 1 1v4z"/>
                    </svg>
<!--                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 55 55" style="position: absolute; top: 11px; right: -8px; cursor: pointer;">-->
<!--                        <path d="M 7 4 C 6.744125 4 6.4879687 4.0974687 6.2929688 4.2929688 L 4.2929688 6.2929688 C 3.9019687 6.6839688 3.9019687 7.3170313 4.2929688 7.7070312 L 11.585938 15 L 4.2929688 22.292969 C 3.9019687 22.683969 3.9019687 23.317031 4.2929688 23.707031 L 6.2929688 25.707031 C 6.6839688 26.098031 7.3170313 26.098031 7.7070312 25.707031 L 15 18.414062 L 22.292969 25.707031 C 22.682969 26.098031 23.317031 26.098031 23.707031 25.707031 L 25.707031 23.707031 C 26.098031 23.316031 26.098031 22.682969 25.707031 22.292969 L 18.414062 15 L 25.707031 7.7070312 C 26.098031 7.3170312 26.098031 6.6829688 25.707031 6.2929688 L 23.707031 4.2929688 C 23.316031 3.9019687 22.682969 3.9019687 22.292969 4.2929688 L 15 11.585938 L 7.7070312 4.2929688 C 7.5115312 4.0974687 7.255875 4 7 4 z" transform="scale(1.4)"-->
<!--                        />-->
<!--                    </svg>-->
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

        <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primar btn-lg" href="/views/members/relationsform.php?id=<?= $id ?>">Додати звʼязок з родиною</a>

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
