<?php

require_once '../Db.php';

//$controller = new Controller();
//$controller->runAction($_GET['action'] ?? '');
$db = new Db();
$allRows = $db->getAllRows();


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
    <script src="https://cdn.tailwindcss.com"></script>

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

                            <a href="" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white"
                               aria-current="page">До дерева</a>
                            <a href="#"
                               class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Список
                                членів родини
                            </a>
                        </div>

                    </div>
                </div>
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
        <p class="fw-bold fw-bolder">Візуалізація родинного дерева</p>
    </div>

    <!------------------Card of member ---------------------->
    <div class="container mt-4">
        <div class="card-body row g-4">

        <?php foreach($allRows as $row): ?>
            <div class="card mr-3" style="width: 18rem; display: flex; justify-content: center; align-items: center;">

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
                        <?php if(!empty($row['death_date'])): ?>
                        <br> <?= date('d-m-Y', strtotime($row["death_date"])) ?>
                        <?php endif;?>
                    </li>

                </ul>
                <div class="card-body">
                    <a href="#" class="card-link text-primary">Більше інформаціїї</a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!------------------FORM ---------------------->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 mt-5 mb-5">
                <h1 class="text-center fs-4 mt-2 mb-4 text-primary">Форма додавання члена сімʼї</h1>
                <form class="d-block p-2" action="/controller.php?action=create" method="POST"
                      enctype="multipart/form-data">
                    <!--photo -->
                    <div class="mb-3">
                        <!--                        <input type="hidden" name="user_id" value="1"> -->
                        <label for="avatar" class="form-label">Завантажити фотографію:</label>

                        <input type="file" class="form-control" name="avatar" id="avatar"
                               accept="image/png, image/jpeg">
                        <input type="hidden" name="avatar_path" value="">
                        <!-- Тут зберігається шлях до аватара -->
                    </div>
                    <!--description to photo -->
                    <div class="mb-3">
                        <label for="photo_description" class="form-label">Опис до фотографії</label>
                        <textarea class="form-control" name="file_description" id="photo_description" rows="3"
                                  placeholder="Опис до фотографії"></textarea>
                    </div>
                    <!--Surname -->
                    <div class="mb-3">
                        <label for="surname" class="form-label">Прізвище</label>
                        <input class="form-control" name="surname" type="text" id="surname" placeholder="Прізвище">
                    </div>
                    <!--Maiden name  -->
                    <div class="mb-3">
                        <label for="maiden_name" class="form-label">Дівоче</label>
                        <input class="form-control" name="maiden_name" type="text" id="maiden_name"
                               placeholder="Дівоче">
                    </div>
                    <!--name  -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Імʼя</label>
                        <input class="form-control" name="name" type="text" id="name" placeholder="Імʼя">
                    </div>
                    <!-- fatherly -->
                    <div class="mb-3">
                        <label for="fatherly" class="form-label">По-батькові</label>
                        <input class="form-control" name="fatherly" type="text" id="fatherly"
                               placeholder="По-батькові">
                    </div>
                    <!--The Birthday date -->
                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Дата народження</label>
                        <input class="form-control" name="birth_date" type="date" id="birth_date">
                    </div>
                    <!--The Death date -->
                    <div class="mb-3">
                        <label for="status">Статус:</label>
                        <select id="status" name="status">
                            <option value="alive">Живий</option>
                            <option value="deceased">Померлий</option>
                        </select>
                        <div id="death-date-field" style="display: none;">
                            <label for="death_date" class="form-label">Дата завершення життєвого шляху:</label>
                            <input name="death_date" class="form-control" type="date" id="death_date"">
                        </div>
                    </div>
                    <!--about person -->
                    <div class="mb-3">
                        <label for="history" class="form-label">Історія</label>
                        <textarea class="form-control" name="history" id="history" rows="3"
                                  placeholder="Трохи історії..."></textarea>
                    </div>
                    <div class="d-grid gap-2 col-6 mx-auto mt-3">
                        <button type="submit" class="btn btn-outline-primary btn-lg">Зберегти</button>
                    </div>
                </form>
            </div>
        </div>

        <!------------------LIST RELATIVES ---------------------->
        <div class="row">
            <div class="">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th scope="col">Фотографія</th>
                        <th scope="col">Опис до фотографії</th>
                        <th scope="col">Прізвище</th>
                        <th scope="col">Дівоче</th>
                        <th scope="col">Імʼя</th>
                        <th scope="col">По-батькові</th>
                        <th scope="col">Дата народження</th>
                        <th scope="col">Дата смерті</th>
                        <th scope="col">Історія</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody id="list-container">
                    <?php foreach ($allRows as $row) : ?>
                        <tr>
                            <td>
                                <?php if (!empty ($row["avatar_path"])): ?>
                                    <img src="<?= htmlspecialchars($row["avatar_path"]) ?>" alt="фото"
                                         style="width: 50px; height: 50px; object-fit: cover;">
                                <?php else: ?>
                                    <span>Відсутня фотографія</span>
                                <?php endif; ?>
                            </td>
                            <td><?= $row["file_description"] ?></td>
                            <td><?= $row["surname"] ?></td>
                            <td><?= $row["maiden_name"] ?></td>
                            <td><?= $row["name"] ?></td>
                            <td><?= $row["fatherly"] ?></td>
                            <td><?= $row["birth_date"] ?></td>
                            <td><?= $row["death_date"] ?></td>
                            <td><?= $row["history"] ?></td>
                            <td>
                                <button type="button" class="btn btn-outline-secondary">
                                    <a href="/edit.php?id=<?= $row['id'] ?>">Редагувати</a>
                                </button>
                            </td>
                            <td>
                                <form action="/controller.php?action=delete" method="POST">
                                    <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                    <button type="submit" class="btn btn-outline-danger">Видалити запис</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>