<?php

require_once '../../BaseController.php';
class GalleryController extends BaseController
{
    public function actionCreateCard()
    {
        if($_POST) {

            $image_path = '';

            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
                $family_member_id = $_POST['family_member_id'] ?? '';
                $uploadBaseDir = __DIR__ .'/../img/'; // Базова Директорія для збереження фото

                //назва папки для конкретної людини
                $memberFolder = $uploadBaseDir . $family_member_id;

                // Перевіряємо, чи існує папка. Якщо ні — створюємо її
                if(!is_dir($memberFolder)){
                    mkdir($memberFolder, 0777, true); // Рекурсивно створюємо папку з правами доступу 0777
                }

                // Створюємо унікальне ім'я для файлу
                $fileName = uniqid(). '-' . basename($_FILES['image']['name']);
                $filePath = $memberFolder . '/' . $fileName;

                // Переміщуємо файл у папку
                if(move_uploaded_file($_FILES['image']['tmp_name'], $filePath)){
                    $image_path =  '/../img/' . $family_member_id . '/' . $fileName; // Шлях до фото відносно веб-сервера
                }else{
                    die('Не вдалося завантажити файл');
                }
            }

            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';

            $this->db->createCard($family_member_id, $image_path, $title, $description);

            header('Location: /');
            exit();

        }

    }

}

$controller = new GalleryController();
$controller->runAction($_GET['action'] ?? '');