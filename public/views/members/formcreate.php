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

<!------------------FORM ---------------------->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 mt-5 mb-5">
            <h1 class="text-center fs-4 mt-2 mb-4 text-primary">Форма додавання члена сімʼї</h1>
            <form class="d-block p-2" action="/controllers/MembersController.php?action=create" method="POST"
                  enctype="multipart/form-data">

                <!--radiobutt male/femail -->
                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sex" id="male" value="0">
                        <label class="form-check-label" for="male">Чоловік</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sex" id="female" value="1" checked>
                        <label class="form-check-label" for="female">Жінка</label>
                    </div>
                </div>

                <!--photo -->
                <div class="mb-3">
                    <!--                        <input type="hidden" name="user_id" value="1"> -->
                    <label for="avatar" class="form-label">Завантажити фотографію:</label>

                    <input type="file" class="form-control" name="avatar" id="avatar"
                           accept="image/png, image/jpeg">
                    <input type="hidden" name="avatar_path" value="">
                    <!-- Тут зберігається шлях до аватара -->
                </div>
                <!--description to photo -->
                <div class="mb-3">
                    <label for="photo_description" class="form-label">Опис до фотографії</label>
                    <textarea class="form-control" name="file_description" id="photo_description" rows="3"
                              placeholder="Опис до фотографії"></textarea>
                </div>
                <!--Surname -->
                <div class="mb-3">
                    <label for="surname" class="form-label">Прізвище</label>
                    <input class="form-control" name="surname" type="text" id="surname" placeholder="Прізвище">
                </div>
                <!--Maiden name  -->
                <div class="mb-3">
                    <label for="maiden_name" class="form-label">Дівоче</label>
                    <input class="form-control" name="maiden_name" type="text" id="maiden_name"
                           placeholder="Дівоче">
                </div>
                <!--name  -->
                <div class="mb-3">
                    <label for="name" class="form-label">Імʼя</label>
                    <input class="form-control" name="name" type="text" id="name" placeholder="Імʼя">
                </div>
                <!-- fatherly -->
                <div class="mb-3">
                    <label for="fatherly" class="form-label">По-батькові</label>
                    <input class="form-control" name="fatherly" type="text" id="fatherly"
                           placeholder="По-батькові">
                </div>
                <!--The Birthday date -->
                <div class="mb-3">
                    <label for="birth_date" class="form-label">Дата народження</label>
                    <input class="form-control" name="birth_date" type="date" id="birth_date">
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
                        <input name="death_date" class="form-control" type="date" id="death_date"">
                    </div>
                </div>
                <!--about person -->
                <div class="mb-3">
                    <label for="history" class="form-label">Історія</label>
                    <textarea class="form-control" name="history" id="history" rows="3"
                              placeholder="Трохи історії..."></textarea>
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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>
