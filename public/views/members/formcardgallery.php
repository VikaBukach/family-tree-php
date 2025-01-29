<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use FamilyTree\Db;

if (empty($_GET['id'])) {
    header('Location: /');
}

$id = $_GET['id'];
$db = Db::getInstance();
$family_members = $db->getAllRows();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Cormorant+Unicase:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Styles -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
    <!-- Or for RTL support -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css"/>
    <link rel="stylesheet" href="/css/styles.css">
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 mt-5 mb-5">
            <h1 class="text-center mt-2 mb-4 t-h1">Форма додавання картки спогадів </h1>

            <form action="/controllers/GalleryController.php?action=createCard" method="POST" class="d-block p-2" enctype="multipart/form-data">
                <div class="mb-3">
                    <input type="hidden" name="family_member_id" value="<?= $id ?>">
                    <label for="image" class="form-label">Зображення:</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/png, image/jpeg">
                    <input type="hidden" name="image_path" value="">
                </div>

                <!-- Для вибору людей на фото-->

                <div class="mb-3">
                    <label for="members" class="t-h1">Люди на фотографії:</label>
                    <select name="family_members[]" id="members" class="form-select mt-3 mb-3" multiple aria-label="Default select example">
                        <?php foreach ($family_members as $member): ?>
                            <option value="<?= $member['id'] ?>"><?= $member['name'] . ' ' . $member['surname'] ?></option>
                        <?php endforeach; ?>

                    </select>
                </div>



                <div class="mb-3">
                    <label for="title" class="form-label">Заголовок:</label>
                    <input type="text" name="title" id="title" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Опис:</label>
                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                </div>

                <button type="submit" class=" d-grid gap-2 col-6 mx-auto mt-3 btn btn-primar">Створити картку</button>
            </form>
        </div>
    </div>

    <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primar btn-lg" href="/views/members/gallery.php?id=<?= $id ?>">
        Повернутись до галереї спогадів
    </a>
    <a class="d-grid gap-2 col-6 mx-auto mt-3 btn btn-outline-primar btn-lg" href="/">
        Повернутись на головну
    </a>
</div>


<script>
        $('#members').select2({
            theme: "bootstrap-5",
            containerCssClass: "select2--small", // For Select2 v4.0
            selectionCssClass: "select2--small", // For Select2 v4.1
            dropdownCssClass: "select2--small",
            placeholder: "Oберіть членів родини",
            allowClear: true
        });

</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</body>
</html>