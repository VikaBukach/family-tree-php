<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

use FamilyTree\Db;
use FamilyTree\RoleRelationships;

if (empty($_GET['id'])) {
    header('Location: /');
}
$id = $_GET['id'];

$db = Db::getInstance();
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
    <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300..700&family=Cormorant+Unicase:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"/>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"/>
    <!-- Or for RTL support -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.rtl.min.css"/>
    <link rel="stylesheet" href="/css/styles.css">

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


</head>
<body>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 mt-5 mb-5">
            <h1 class="text-center mb-4 mt-4">Форма додавання відносин</h1>

            <form id="relations-form" action="/controllers/RelationshipsController.php?action=createRelation"
                  method="POST">

                <div class="mb-3">
                    <label for="member_id" class="t-h1">Член родини:</label>
                    <select name="member_id" class="form-select mt-3 mb-3" id="member-id"
                            aria-label="Default select example">
                        <option value="<?= $member['id'] ?>"
                                selected><?= $member['name'] . ' ' . $member['surname'] ?></option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="related_member_id" class="t-h1">Повʼязаний член родини:</label>
                    <select name="related_member_id" id="related_member_id" class="form-select mt-3 mb-3"
                            aria-label="Default select example">
                        <option selected value="">Oберіть іншого члена родини щоб повʼязати звязок:</option>

                        <?php foreach ($allRows as $row) : ?>

                            <option value="<?= $row['id'] ?>"><?= $row['name'] . ' ' . $row['surname'] ?></option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="relationship_type" class="t-h1">Тип звʼязку(роль):</label>
                    <select name="relationship_type" id="relationship_type" class="form-select mt-3 mb-3"
                            aria-label="Default select example">

                        <option selected value="">Oберіть роль:</option>

                        <?php foreach (RoleRelationships::getAllRoles() as $roleKey => $roleName): ?>

                            <option value="<?= $roleKey ?>"><?= $roleName ?></option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="d-grid gap-2 col-6 mx-auto mt-3">
                    <button type="submit" class="btn btn-outline-primar btn-lg mt-3">Зберегти</button>
                </div>
            </form>
        </div>
    </div>
    <div class="container">
        <h2 class="text-center mb-4 mt-4">Родинні зв’язки</h2>
        <div class="relationships" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">

            <ul class="card-container" style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">


                <li class="card"
                    style="width: 150px; height: 180px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; display: flex; flex-direction: column; align-items: center; padding: 5px;">
                    <img src="" alt="фото"
                         style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; margin-bottom: 10px;">
                    <h6 style="margin-bottom: 5px; display: flex; text-align: center;">

                    </h6>
                    <p style="font-size: 14px; color: #555;">

                    </p>

                </li>

            </ul>

        </div>
        <div class="d-grid gap-2 col-6 mx-auto mt-3">
            <a class="btn btn-outline-primar btn-lg" href="/">Повернутись на головну</a>
        </div>
    </div>
</div>

<script src="/js/bootstrap.bundle.min.js"></script>

<script>

    $("#related_member_id").select2({
        theme: "bootstrap-5",
        containerCssClass: "select2--small", // For Select2 v4.0
        selectionCssClass: "select2--small", // For Select2 v4.1
        dropdownCssClass: "select2--small",
    });

</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    $('#relations-form').on('submit', function (e) {
        e.preventDefault();

        var relatType = $('#relationship_type').val();
        console.log(relatType)

    })

</script>

</body>
</html>

