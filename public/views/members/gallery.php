<?php

require_once '../../../Db.php';
$id = $_GET['id'];
$db = new Db();
$familyMember = $db->getRowById($id);
$allCards = $db->getAllCards();
//var_dump($allCards);



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
            <button class="btn btn-secondary dropdown-toggle" style="margin-bottom: 30px;" type="button" data-bs-toggle="dropdown"
                    data-bs-auto-close="inside" aria-expanded="false">
                Додати спогад
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/views/members/formcardgallery.php?id=<?= $id ?>">Фото</a></li>

                <li><a class="dropdown-item" href="#">Текс</a></li>
            </ul>
        </div>

            <div class="card-container" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
                <?php foreach ($allCards as $card) : ?>
                    <!------------------створення карточки---------------------->
                <div class="card" style="width: 400px; height: 500px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; align-items: center; padding: 5px;">
                    <div style="width: 100%; height: 75%; display: flex; justify-content: center; align-items: center; margin-bottom: 10px;">
                    <?php if (!empty ($card['image_path'])) : ?>
                        <img src="<?= htmlspecialchars($card['image_path']) ?>" class="card-img-top" alt="фото"
                             style="max-width: 75%; max-height: 100%; object-fit: cover;">
                    <?php else: ?>
                        <span>Відсутне фото</span>
                    <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $card['title'] ?></h5>
                        <p class="card-text"><?= $card['description'] ?></p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <!------------------створення біографіі(виводиться з дискрипшина) ---------------------->

        <div class="card" style="margin-top: 50px; margin-bottom: 50px;">

            <div class="card-body"><?= $familyMember['file_description']?></div>

        </div>




        <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primary btn-lg" href="/" style="margin-bottom: 30px;">
            Повернутись на головну
        </a>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/main.js"></script>
</body>
</html>