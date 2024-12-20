<?php

require_once '../../BaseController.php';
class GalleryController extends BaseController
{
    public function actionCreateCard()
    {
        if($_POST) {

            $image_path = '';

            if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
                $uploadDir = __DIR__ .'/../img/'; // Директорія для збереження фото
                $fileName = uniqid(). '-' . basename($_FILES['image']['name']);
                $filePath = $uploadDir . $fileName;

                if(move_uploaded_file($_FILES['image']['tmp_name'], $filePath)){
                    $image_path =  '/../img/' . $fileName; // Шлях до фото
                }
            }

            $family_member_id = $_POST['family_member_id'] ?? '';
            $title = $_POST['title'] ?? '';
            $description = $_POST['description'] ?? '';

            $this->db->createCard($family_member_id, $image_path, $title, $description);

            header('Location: /');

        }

    }

}

$controller = new GalleryController();
$controller->runAction($_GET['action'] ?? '');