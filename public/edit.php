<?php
$id = $_GET['id'];
//var_dump($_GET['id']);

require_once '../Db.php';

$db = new Db();
$member = $db->getRowById($id);
//$v = 1;

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
            <h1 class="text-center fs-4 mt-2 mb-4 text-primary">Форма редагування члена сімʼї</h1>
            <form class="d-block p-2" action="/?action=update" method="POST">
                <!--photo -->
                <!--                    <div class="mb-3">-->
                <!--                        <label for="photo" class="form-label">Фото</label>-->
                <!--                        <input class="form-control" type="file" id="photo">-->
                <!--                    </div>-->
                <!--description to photo -->
                <div class="mb-3">
                    <input type="hidden" name="id" value="<?= $member['id']; ?>">
                    <label for="photo_description" class="form-label">Опис до фотографії</label>
                    <textarea class="form-control" name="file_description" id="photo_description" rows="3"
                              placeholder="Опис до фотографії"><?= $member['file_description']; ?></textarea>
                </div>
                <!--Surname -->
                <div class="mb-3">
                    <label for="surname" class="form-label">Прізвище</label>
                    <input class="form-control" value="<?= $member['surname']; ?>" name="surname" type="text"
                           id="surname" placeholder="Прізвище">
                </div>
                <!--Maiden name  -->
                <div class="mb-3">
                    <label for="maiden_name" class="form-label">Дівоче</label>
                    <input class="form-control" value="<?= $member['maiden_name']; ?>" name="maiden_name" type="text"
                           id="maiden_name"
                           placeholder="Дівоче">
                </div>
                <!--name  -->
                <div class="mb-3">
                    <label for="name" class="form-label">Імʼя</label>
                    <input class="form-control" value="<?= $member['name']; ?>" name="name" type="text" id="name"
                           placeholder="Імʼя">
                </div>
                <!-- fatherly -->
                <div class="mb-3">
                    <label for="fatherly" class="form-label">По-батькові</label>
                    <input class="form-control" value="<?= $member['fatherly']; ?>" name="fatherly" type="text"
                           id="fatherly" placeholder="По-батькові">
                </div>
                <!--The Birthday date -->
                <div class="mb-3">
                    <label for="birth_date" class="form-label">Дата народження</label>
                    <input class="form-control" value="<?= $member['birth_date']; ?>" name="birth_date"  type="date"
                           id="birth_date">
                </div>
                <!--The Death date -->
                <!--                    <div class="mb-3">-->
                <!--                        <label for="death_date" class="form-label">Дата смерті</label>-->
                <!--                        <input class="form-control" type="text" id="death_date" placeholder="дд-мм-рррр">-->
                <!--                    </div>-->
                <!--about person -->
                <div class="mb-3">
                    <label for="history" class="form-label">Історія</label>
                    <textarea class="form-control" name="history" id="history" rows="3"
                              placeholder="Трохи історії..."><?= $member['history']; ?></textarea>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto mt-3">
                    <a class="btn btn-outline-primary btn-lg" href="/">
                        <button type="submit">Оновити</button>
                    </a>
                </div>
                <a class="d-grid gap-2 col-6 mx-auto mt-3" href="/">
                    <button type="submit" class="btn btn-outline-primary btn-lg">Повернутись до списку</button>
                </a>

            </form>
        </div>
    </div>
</div>
</body>
</html>

