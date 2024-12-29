<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FamilyTree\Db;

$db = new Db();
$allRows = $db->getAllRows();

//$searchResults = $db->getRelativesByNames($query);

$fg = 'dd'
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <title>Family tree</title>
</head>
<body>

<header>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Family Tree</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Головна</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/views/members/formcreate.php">Додати члена сімʼї</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/views/members/list.php">Список
                            членів родини</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" style="" method="POST"
                      action="/controllers/MembersController.php?action=searchRelative">
                    <input class="form-control me-2" name="query" type="search" placeholder="Введіть прізвище"
                           aria-label="Search" required>
                    <button class="btn btn-outline-success" type="submit">Пошук</button>
                </form>
            </div>
        </div>
    </nav>
</header>
<main class="container-fluid">
    <div class="text-center">
        <h1 class="fw-bolder lh-sm fs-4 text mt-3 mb-3" style="max-width: 1000px; margin: 0 auto;">
            Родинне дерево — це не просто перелік імен чи дат, це жива історія, яка об’єднує минуле,
            теперішнє та майбутнє. Вивчаючи свої корені, ми дізнаємося більше про своїх предків, їхній шлях у житті,
            традиції та цінності, які передавалися з покоління в покоління. Цей проєкт покликаний зберегти нашу
            родинну спадщину,
            об’єднати родичів та відкрити нові сторінки нашої сімейної історії.
        </h1>
    </div>

    <!------------------Card of member ---------------------->
    <div class="container mt-4">
        <div class="card-body row g-4">





            <?php foreach ($allRows as $row): ?>
                <div class="card mr-3"
                     style="width: 18rem; display: flex; justify-content: center; align-items: center;">

                    <?php if (!empty ($row["avatar_path"])): ?>
                        <img src="<?= htmlspecialchars($row["avatar_path"]) ?>" class="card-img-top mt-2" alt="фото"
                             style="width: 180px; height: 250px; object-fit: cover;">
                    <?php else: ?>
                        <span>Відсутне фото</span>
                    <?php endif; ?>

                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"> <?= $row["surname"] ?></li>

                        <?php if (!empty($row["maiden_name"])): ?>
                            <li class="list-group-item"> Дівоче: <?= $row["maiden_name"] ?>
                            </li>
                        <?php endif; ?>

                        <li class="list-group-item"><?= $row["name"] ?></li>
                        <li class="list-group-item"><?= $row["fatherly"] ?></li>

                        <li class="list-group-item"><?= date('d-m-Y', strtotime($row["birth_date"])) ?>
                            <?php if (!empty($row['death_date'])): ?>
                                <br> <?= date('d-m-Y', strtotime($row["death_date"])) ?>
                            <?php endif; ?>
                        </li>

                    </ul>
                    <div class="card-body">
                        <a href="/views/members/gallery.php?id=<?= $row['id'] ?>" class="card-link text-primary">Більше
                            інформаціїї</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!------------------FORM ---------------------->

    <!------------LIST RELATIVES ---------------------->

</main>


<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>