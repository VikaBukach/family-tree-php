<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use FamilyTree\Db;
use FamilyTree\RoleRelationships;

if (empty($_GET['id'])) {
    header('Location: /');
}
$id = $_GET['id'];

$db = new Db();
$member = $db->getRowById($id);
$allRows = $db->getAllRows();
$allRoles = RoleRelationships::getAllRoles();

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
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 mt-5 mb-5">
            <h1 class="text-center fs-4 mt-2 mb-4 text-primary">Форма додавання відносин</h1>

            <form action="/controllers/RelationshipsController.php?action=createRelation" method="POST">

                <div class="mb-3">
                <label for="member_id" class="text-primary">Член родини:</label>
                <select name="member_id" class="form-select mt-3 mb-3" aria-label="Default select example">
                    <option value="<?=$member['id'] ?>" selected><?=$member['name'] .' '. $member['surname']?></option>
                </select>
                </div>

                <div class="mb-3">
                <label for="related_member_id" class="text-primary">Повʼязаний член родини:</label>
                <select name="related_member_id" id="related_member_id" class="form-select mt-3 mb-3" aria-label="Default select example">
                    <option selected value="">Oберіть іншого члена родини щоб повʼязати звязок:</option>

                    <?php foreach ($allRows as $row) : ?>

                    <option value="<?=$row['id'] ?>"><?=$row['name'] .' '. $row['surname']?></option>

                    <?php endforeach; ?>
                </select>
                </div>

                <div class="mb-3">
                <label for="relationship_type" class="text-primary">Тип звʼязку(роль):</label>
                <select name="relationship_type" id="relationship_type" class="form-select mt-3 mb-3" aria-label="Default select example">

                    <option selected value="">Oберіть роль:</option>

                    <?php foreach (RoleRelationships::getAllRoles() as $roleKey => $roleName): ?>

                    <option value="<?= $roleKey?>"><?= $roleName?></option>

                  <?php endforeach; ?>
                </select>
                </div>

                <div class="d-grid gap-2 col-6 mx-auto mt-3">
                    <button type="submit" class="btn btn-outline-primary btn-lg">Зберегти</button>
                </div>
            </form>

            <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primary btn-lg" href="/">
                Повернутись на головну
            </a>
        </div>
    </div>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>

