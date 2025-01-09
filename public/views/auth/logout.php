<?php
require_once __DIR__ . '/../../../vendor/autoload.php';

session_start();

//видалення всіх сессій
session_unset();
session_destroy();

//відповідь про успішний вихід
http_response_code(200);
exit();
