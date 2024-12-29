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
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">

                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <a href="/"
                               class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white""
                            aria-current="page">Головна
                            </a>
                            <a href="/views/members/formcreate.php"
                               class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white"
                               aria-current="page">Додати члена сімʼї</a>
                            <a href="/views/members/list.php"
                               class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Список
                                членів родини</a>
                        </div>
                    </div>
                </div>
                <form class="d-flex" role="search" style="" method="POST"
                      action="/controllers/MembersController.php?action=searchRelative">
                    <input class="form-control me-2" name="query" type="search" placeholder="Введіть прізвище"
                           aria-label="Search" required>
                    <button class="btn btn-outline-success" type="submit">Пошук</button>
                </form>
            </div>
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
<script src="/js/jquery.min.js"></script>
</body>
</html>