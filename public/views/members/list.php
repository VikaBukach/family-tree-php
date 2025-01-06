<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use FamilyTree\Db;

$db = Db::getInstance();
$allRows = $db->getAllRows();

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
<!------------------LIST RELATIVES ---------------------->
<div class="container-fluid">
    <div class="row">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Фото</th>
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
                    <td><?= $row["surname"] ?></td>
                    <td><?= $row["maiden_name"] ?></td>
                    <td><?= $row["name"] ?></td>
                    <td><?= $row["fatherly"] ?></td>
                    <td><?= $row["birth_date"] ?></td>
                    <td><?= $row["death_date"] ?></td>
                    <td><?= $row["history"] ?></td>
                    <td>
                            <a class="btn btn-outline-secondary" href="/views/members/edit.php?id=<?= $row['id'] ?>">Редагувати</a>
                            <a class="btn btn-outline-secondary" href="/views/members/relationsform.php?id=<?= $row['id'] ?>">Додати звʼязок</a>
                    </td>
                    <td>
                        <form action="/controllers/MembersController.php?action=delete" method="POST">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" class="btn btn-outline-danger">Видалити запис</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primary btn-lg" href="/" style="margin-bottom: 30px">
            Повернутись на головну
        </a>
    </div>
</div>


<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
