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

    <title>Family tree</title>
</head>
<body>
<header>
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">

                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">

                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <!-- web version -->
                            <a href="" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white"
                               aria-current="page">До дерева</a>
                            <a href="#"
                               class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Список
                                членів родини
                            </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<main class="container-fluid">
    <section>
        <div class="text-center mt-1 mb-1">
            <h1 class="fw-bold text-primary">Вступна інформація про родинне дерево</h1>
            <p class="fw-bold text-primary">Візуалізація родинного дерева</p>
            <p class="fw-bold text-primary">Можливість натискати на членів сім'ї для перегляду деталей.</p>
            <div class="text-center mt-2 mb-1">
                <label for="exampleDataList" class="form-label">Пошук</label>
                <input class="form-control" list="datalistOptions" id="exampleDataList" placeholder="Type to search...">
                <datalist id="datalistOptions">
                    <option value="San Francisco">
                    <option value="New York">
                    <option value="Seattle">
                    <option value="Los Angeles">
                    <option value="Chicago">
                </datalist>
        </div>
    </section>
    <!------------------FORM ---------------------->
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6">
                <h1 class="text-center fs-4 mt-2 mb-4 text-primary">Форма додавання члена сімʼї</h1>
                <form class="d-block p-2" action="" method="">
                    <!--photo -->
                    <div class="mb-3">
                        <label for="photo" class="form-label">Фото</label>
                        <input class="form-control" type="file" id="photo">
                    </div>
                    <!--description to photo -->
                    <div class="mb-3">
                        <label for="photo_description" class="form-label">Опис до фотографії</label>
                        <textarea class="form-control" id="photo_description" rows="3" placeholder="Опис до фотографії"></textarea>
                    </div>
                    <!--Name after got marriage  -->
                    <div class="mb-3">
                        <label for="first_name" class="form-label">Прізвище</label>
                        <input class="form-control" type="text" id="first_name" placeholder="Прізвище">
                    </div>
                    <!--Maiden name  -->
                    <div class="mb-3">
                        <label for="maiden_name" class="form-label">Дівоче</label>
                        <input class="form-control" type="text" id="maiden_name" placeholder="Дівоче">
                    </div>
                    <!--name  -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Імʼя</label>
                        <input class="form-control" type="text" id="name" placeholder="Імʼя">
                    </div>
                    <!-- fatherly -->
                    <div class="mb-3">
                        <label for="fatherly" class="form-label">По-батькові</label>
                        <input class="form-control" type="text" id="fatherly" placeholder="По-батькові">
                    </div>
                    <!--The Birthday date -->
                    <div class="mb-3">
                        <label for="birth_date" class="form-label">Дата народження</label>
                        <input class="form-control" type="text" id="birth_date" placeholder="ДД.ММ.ГГГГ">
                    </div>
                    <!--The Death date -->
                    <div class="mb-3">
                        <label for="death_date" class="form-label">Дата смерті</label>
                        <input class="form-control" type="text" id="death_date" placeholder="ДД.ММ.ГГГГ">
                    </div>
                    <!--about person -->
                    <div class="mb-3">
                        <label for="history" class="form-label">Історія</label>
                        <textarea class="form-control" id="history" rows="3" placeholder="Трохи історії..."></textarea>
                    </div>
                    <div class="mb-4">
                        <button type="submit" class="btn btn-primary">Зберегти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!------------------LIST RELATIVES ---------------------->
    <table class="table">
        <thead>
        <tr>
            <th scope="col">Фото</th>
            <th scope="col">Опис до фотографії</th>
            <th scope="col">Прізвище</th>
            <th scope="col">Дівоче</th>
            <th scope="col">Імʼя</th>
            <th scope="col">По-батькові</th>
            <th scope="col">Дата народження</th>
            <th scope="col">Дата смерті</th>
            <th scope="col">Історія</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th scope="row">1</th>
            <td>img</td>
            <td>Це фотографія 1959 року</td>
            <td>Тітов</td>
            <td>Железняк</td>
            <td>Надія</td>
            <td>Петрівна</td>
            <td>03.12.2019</td>
            <td>Бабушкіна історія життя</td>

        </tr>

        </tbody>
    </table>

</main>
</body>
</html>