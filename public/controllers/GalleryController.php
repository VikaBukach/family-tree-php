<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use FamilyTree\BaseController;

class GalleryController extends BaseController
{
    public function actionInsertCard()
    {
        $this->checkAccess('create');

        if ($_POST) {

            $image_path = '';

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $familyMemberId = $_POST['family_member_id'] ?? '';
                $uploadBaseDir = __DIR__ . '/../img/'; // Базова Директорія для збереження фото

                //назва папки для конкретної людини
                $memberFolder = $uploadBaseDir . $familyMemberId;

                // Перевіряємо, чи існує папка. Якщо ні — створюємо її
                if (!is_dir($memberFolder)) {
                    mkdir($memberFolder, 0777, true); // Рекурсивно створюємо папку з правами доступу 0777
                }

                // Створюємо унікальне ім'я для файлу
                $fileName = uniqid() . '-' . basename($_FILES['image']['name']);
                $filePath = $memberFolder . '/' . $fileName;

                // Переміщуємо файл у папку
                if (move_uploaded_file($_FILES['image']['tmp_name'], $filePath)) {
                    $image_path = '/../img/' . $familyMemberId . '/' . $fileName; // Шлях до фото відносно веб-сервера
                } else {
                    die('Не вдалося завантажити файл');
                }
            }

            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';
            $relatedMembers = $_POST['family_members'] ?? []; // Люди, які є на фотографії

            // Додати запис у таблицю `cards`
            $cardId = $this->db->insertCard($familyMemberId, $image_path, $title, $description);

            // Додати зв'язки в таблицю `card_members`
            foreach ($relatedMembers as $memberId){
                $this->db->insertCardMember($cardId, $memberId);
            }

            header("Location: /views/members/gallery.php?id=$familyMemberId");
            exit();

        }
    }

        public function actionUpdateCard()
    {
        $this->checkAccess('update');

        if($_POST) {
            $card_id = $_POST['id'] ?? null;
            $family_member_id = $_POST['family_member_id'] ?? null;
            $current_image_path = $_POST['current_image_path'] ?? null;
            $title = $_POST['title'] ?? null;
            $description = $_POST['description'] ?? null;


            $image_path = $current_image_path;

            // Якщо завантажується новий файл
            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
                $uploadBaseDir = __DIR__ .'/../img/';
                $memberFolder = $uploadBaseDir . $family_member_id;

                if(!is_dir($memberFolder)){
                    mkdir($memberFolder, 0777, true);
                }

                $fileName = uniqid(). '-' . basename($_FILES['image']['name']);
                $filePath = $memberFolder . '/' . $fileName;

                if(move_uploaded_file($_FILES['image']['tmp_name'], $filePath)){
                    $image_path =  '/../img/' . $family_member_id . '/' . $fileName; // Шлях до фото
                }

                //deleted old img
                $fullImagePath = __DIR__ . $current_image_path;
                if ($current_image_path && file_exists($fullImagePath)) {
                    unlink($fullImagePath);
                } else {
                    error_log('Старе зображення не знайдено' . $fullImagePath);
                }
            }

            $this->db->updateCard($card_id, $family_member_id, $image_path, $title, $description);

            header("Location: /views/members/gallery.php?id=$family_member_id");
            exit();
        }
    }
        public function actionDeleteCard()
    {
        $this->checkAccess('update');

        if($_POST) {
            $id = $_POST['id'];
        }

        $this->db->deleteCard($id);

        header("Location: {$_SERVER ['HTTP_REFERER']}");
        exit;
    }

}

$controller = new GalleryController();
$controller->runAction($_GET['action'] ?? '');