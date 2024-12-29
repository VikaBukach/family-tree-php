<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use FamilyTree\Db;
use FamilyTree\RoleRelationships;
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
    <link href="/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container-fluid">
    <div class="text-center mt-5 mb-3">
        <h1 class="fw-bolder lh-sm fs-1 text " style="max-width: 1000px; margin: 0 auto;">Інформація про члена
            родини</h1>
    </div>

    <div class="container">
        <div class="member card-container"
             style="display: flex; justify-content: center; align-items: center;">
            <div class="card" style="width: 18rem; border: 1px solid #ddd; border-radius: 10px; padding: 15px; text-align: center;">
            <img src="<?= $familyMember['avatar_path'] ?>" alt="фото" style="border-radius: 50%;">
            <h2 style="margin-top: 15px"><?= $familyMember['name'] . ' ' . $familyMember['surname'] ?></h2>
            </div>
        </div>

        <h2 class="text-center mb-4 mt-4">Родинні зв’язки</h2>
        <div class="relationships" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
            <?php if (is_array($relationships) && count($relationships) > 0): ?>
                <ul class="card-container" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
                    <?php foreach ($relationships as $relation): ?>
                        <?php if (!empty($relation->related_avatar) && !empty($relation->related_name) && !empty($relation->related_surname) && !empty($relation->role_type)): ?>
                            <li class="card"
                                style="width: 150px; height: 180px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; align-items: center; padding: 5px;">
                                <img src="<?= $relation->related_avatar ?>" alt="фото" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; margin-bottom: 10px;">
                                <h6 style="margin-bottom: 5px; display: flex; text-align: center;">
                                    <?= $relation->related_surname . ' ' . $relation->related_name ?>:
                                </h6>
                                <p style="font-size: 14px; color: #555;">
                                    <?= RoleRelationships::getNameByKey($relation->role_type) ?>
                                </p>

                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
        <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primary btn-lg" href="/views/members/relationsform.php?id=<?= $id ?>">Додати звʼязок</a>

        <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primary btn-lg" href="/" style="margin-bottom: 30px;">
            Повернутись на головну
        </a>
    </div>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/jquery.min.js"></script>
</body>
</html>
