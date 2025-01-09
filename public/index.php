<?php

require_once __DIR__ . '/../vendor/autoload.php';

use FamilyTree\Db;

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /views/auth/login.php');
    exit;
}

$db = Db::getInstance();
$allRows = $db->getAllRows();

$fg = 'dd'
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;700&display=swap" rel="stylesheet">

    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
    <title>Family tree</title>
</head>
<body>

<header>

    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand align-items-center" href="#">
                <img src="/img/tree.png" class="logo-img" alt="tree" >
                <span class="brand-text">Family Tree</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav" style="justify-content: space-evenly">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/views/members/formcreate.php">Add family member</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/views/members/list.php">List of family members</a>
                    </li>
                </ul>
                <form class="d-flex" role="search" style="" method="POST"
                      action="/controllers/MembersController.php?action=searchRelative">
                    <input class="form-control me-2" name="query" type="search" placeholder="Введіть прізвище"
                           aria-label="Search" required>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
                <svg id="logoutButton" class="svg" width="30px" height="30px" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M13.5 7.5L10.5 10.75M13.5 7.5L10.5 4.5M13.5 7.5L4 7.5M8 13.5H1.5L1.5 1.5L8 1.5"
                          stroke="#b9a141" stroke-width="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="13.5" cy="7.5" r="0.5" fill="#b9a141"/>
                    <circle cx="10.5" cy="4.5" r="0.4" fill="#b9a141"/>
                    <circle cx="10.5" cy="10.75" r="0.4" fill="#b9a141"/>
                </svg>
            </div>
        </div>
    </nav>
</header>
<main class="container-fluid">
    <div class="text-center">
        <h1 class="fw-bolder lh-sm fs-3 text mt-3 mb-3" style="max-width: 1200px; margin: 0 auto;">
            Родинне дерево — це не просто перелік імен чи дат, це жива історія, яка об’єднує минуле,
            теперішнє та майбутнє. Вивчаючи свої корені, ми дізнаємося більше про своїх предків, їхній шлях у житті,
            традиції та цінності, які передавалися з покоління в покоління. Цей проєкт покликаний зберегти нашу
            родинну спадщину,
            об’єднати родичів та відкрити нові сторінки нашої сімейної історії.
        </h1>
    </div>

    <!------------------Card of member ---------------------->
    <div class="container mt-4 parallax-content">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4">

            <?php foreach ($allRows as $row): ?>
                <div class="card mr-3 custom-card"
                     style="width: 16rem; display: flex; justify-content: center; align-items: center; margin-right: 2px;">

                    <?php if (!empty ($row["avatar_path"])): ?>
                        <img src="<?= htmlspecialchars($row["avatar_path"]) ?>" class="card-img-top mt-2" alt="фото"
                             style="width: 180px; height: 250px; object-fit: cover;">
                    <?php else: ?>
                        <span>Відсутне фото</span>
                    <?php endif; ?>

                    <ul class="list-group list-group-flush custom-list">
                        <li class="list-group-item"> <?= $row["surname"] ?></li>

                        <?php if (!empty($row["maiden_name"])): ?>
                            <li class="list-group-item"> Дівоче: <?= $row["maiden_name"] ?>
                            </li>
                        <?php endif; ?>

                        <li class="list-group-item"><?= $row["name"] ?></li>
                        <li class="list-group-item"><?= $row["fatherly"] ?></li>

                        <li class="list-group-item"><?= date('d-m-Y', strtotime($row["birth_date"])) ?>
                            <?php if (!empty($row['death_date'])): ?>
                                <br> <?= date('d-m-Y', strtotime($row["death_date"])) ?>
                            <?php endif; ?>
                        </li>

                    </ul>
                    <div class="card-body">
                        <a href="/views/members/gallery.php?id=<?= $row['id'] ?>" class="btn btn-primar">Більше
                            інформаціїї</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

</main>
<script src="js/jquery.min.js"></script>
<script>
  $(document).ready(function (){
      $('#logoutButton').on('click', function (){
          $.post('/views/auth/logout.php', function (response){
              window.location.href = '/views/auth/login.php';
          }).fail(function (){
              alert('Не вдалося виконати вихід');
          });
      });
  });
</script>
<script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>