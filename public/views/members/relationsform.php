<?php
$id = $_GET['id'];

require_once '../../../Db.php';
$db = new Db();
$member = $db->getRowById($id);
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
</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 mt-5 mb-5">
            <h1 class="text-center fs-4 mt-2 mb-4 text-primary">Форма додавання відносин</h1>

            <form action="controllers/RelationshipsController.php?action=actionCreateRelation" method="POST">
                <input type="hidden" name="id" value="<?=$member['id'] ?>">
                <label for="member_id" class="text-primary">Член родини:</label>
                <select class="form-select mt-3 mb-3" aria-label="Default select example">
                    <option selected><?=$member['name'] .' '. $member['surname']?></option>
                </select>

                <label for="related_member_id" class="text-primary">Повʼязаний член родини:</label>
                <select class="form-select mt-3 mb-3" aria-label="Default select example">
                    <option selected>Oберіть члена родини(member):</option>

                    <?php foreach ($allRows as $row) : ?>

                    <option value="<?=$member['id'] ?>"><?=$row['name'] . $row['surname']?></option>

                    <?php endforeach; ?>
                </select>

                <label for="relationship_type" class="text-primary">Роль(тип звʼязку):</label>
                <select class="form-select mt-3 mb-3" aria-label="Default select example">
                    <!--                    відмалювати циклом-->
                    <option selected>Oберіть роль:</option>
                    <option value="1">Папа</option>
                    <option value="2">мама</option>
                    <option value="3">Бабушка</option>
                    <option value="3">Сестра</option>
                </select>

            </form>


            <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primary btn-lg" href="/">
                Повернутись на головну
            </a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="../../js/main.js"></script>
</body>
</html>

