<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use FamilyTree\Db;
use FamilyTree\structure\FamilyRelationshipsStructure;

if (empty($_GET['id'])) {
    header('Location: /');
}

$id = $_GET['id'];
$db = new Db();
/** @var FamilyRelationshipsStructure[] $relationships */

// Отримуємо відносини для конкретного члена родини:
$relationships = $db->getFamilyRelationships($id);

// Отримуємо основну інформацію про члена родини:
$familyMember = $db->getMemberById($id);
?>


<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


</head>
<body>

<div class="container-fluid">
    <div class="text-center mt-5 mb-3">
        <h1 class="fw-bolder lh-sm fs-1 text " style="max-width: 1000px; margin: 0 auto;">Інформація про члена
            родини</h1>
    </div>

    <div class="container">
        <div class="member card mr-3"
             style="width: 18rem; display: flex; justify-content: center; align-items: center;">
            <img src="<?= $familyMember['avatar_path'] ?>" alt="фото" style="width: 100px;">
            <h2><?= $familyMember['name'] . ' ' . $familyMember['surname'] ?></h2>
        </div>

        <h2>Родинні зв’язки</h2>
        <div class="relationships">
            <?php if (is_array($relationships) && count($relationships) > 0): ?>
                <ul>
                    <?php foreach ($relationships as $relation): ?>
                        <?php if (!empty($relation->related_avatar) && !empty($relation->related_name) && !empty($relation->related_surname) && !empty($relation->role_name)): ?>
                            <li class="card mr-3"
                                style="width: 18rem; display: flex; justify-content: center; align-items: center;">
                                <img src="<?= $relation->related_avatar ?>" alt="фото" style="width: 50px;">
                                <?= $relation->related_surname . ' ' . $relation->related_name ?>:
                                <?= $relation->role_name ?>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
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
