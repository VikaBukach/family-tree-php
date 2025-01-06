<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use FamilyTree\Db;

if (empty($_GET['id'])) {
    header('Location: /');
}

$id = $_GET['id'];
$db = Db::getInstance();
$member = $db->getRowById($id);


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
            <h1 class="text-center fs-4 mt-2 mb-4 text-primary">Форма редагування члена сімʼї</h1>

            <form class="d-block p-2" action="/controllers/MembersController.php?action=update" method="POST" enctype="multipart/form-data">
                <!--radiobutt male/femail -->
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sex" id="male" value="0"
                        <?= $member['sex'] === 0 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="male">Чоловік</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sex" id="female" value="1"
                        <?= $member['sex'] === 1 ? 'checked' : '' ?>>
                        <label class="form-check-label" for="female">Жінка</label>
                    </div>
                </div>

                <!--photo -->
                <div class="mb-3">
                    <label for="avatar" class="form-label">Поточна фотографія:</label>

                    <?php if (!empty($member['avatar_path'])): ?>
                        <img src="<?= htmlspecialchars($member['avatar_path']) ?>" alt="Avatar"
                             style="width: 100px; height: 100px; object-fit: cover;">
                    <?php else: ?>
                        <span>фотографія відсутня</span>
                    <?php endif; ?>

                    <input type="hidden" name="current_avatar" value="<?= htmlspecialchars($member['avatar_path']) ?>">
                    <label class="form-label">Завантажити нову фотографію:</label>
                    <input type="file" class="form-control" name="avatar" id="avatar"
                           accept="image/png, image/jpeg">
                    <input type="hidden" name="avatar_path" value="<?= $member['avatar_path']; ?>">
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
                    <input class="form-control" value="<?= $member['birth_date']; ?>" name="birth_date" type="date"
                           id="birth_date">
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
                        <input value="<?= $member['death_date']; ?>" name="death_date" class="form-control" type="date" id="death_date"">
                    </div>
                </div>

                <!--about person -->
                <div class="mb-3">
                    <label for="history" class="form-label">Історія</label>
                    <textarea class="form-control" name="history" id="history" rows="3"
                              placeholder="опис життєвих подій..."><?= $member['history']; ?></textarea>
                </div>
                <button type="submit" class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primary btn-lg">
                    Зберегти зміни
                </button>
            </form>
            <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primary btn-lg" href="/views/members/gallery.php">
                Повернутись до списку
            </a>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {
        $('#status').change(function () {
            if ($(this).val() === 'deceased') {
                $('#death-date-field').show();
            } else {
                $('#death-date-field').hide();
            }
        });
    });
</script>

<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/jquery.min.js"></script>
</body>
</html>

