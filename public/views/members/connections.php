<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use FamilyTree\Db;

if (empty($_GET['id'])) {
    header('Location: /');
}

$id = $_GET['id'];
$db = new Db();
$relationships = $db->getFamilyRelationships($id);

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
        <h1 class="fw-bolder lh-sm fs-1 text " style="max-width: 1000px; margin: 0 auto;">Родинні звʼязки</h1>
    </div>


    <div class="relationships">
        <?php if (!empty($relationships)): ?>
            <ul>
                <?php foreach ($relationships as $relation): ?>
                    <li>
                        <img src="<?= htmlspecialchars($relation['avatar_path']) ?>" alt="Аватар" style="width: 50px;">
                        <strong><?= htmlspecialchars($relation['relationship_name']) ?>:</strong>
                        <?= htmlspecialchars($relation['name'] . ' ' . $relation['surname']) ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Немає зв’язків для цього члена родини.</p>
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
