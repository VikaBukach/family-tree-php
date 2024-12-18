<?php

require_once 'Db.php';

class Controller
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();

    }

    public function runAction($actionName)
    {
        if(method_exists($this, 'action' . $actionName)){
            return $this->{'action' . $actionName}();
        }
    }

    public function actionCreate()
    {
        if($_POST) {
            // Обробка аватара
            $avatar_path = '';
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {

                $uploadDir = __DIR__ . '/public/img/'; // Директорія для збереження аватарів
                $fileName = uniqid() . '-' . basename($_FILES['avatar']['name']);
                $filePath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath)) {
                    $avatar_path = '/public/img/' . $fileName; // Шлях до аватара
                }
            }

//            $avatar_path = $_POST['avatar_path'];

            $photo_description = $_POST['file_description'] ?? '';
            $surname = $_POST['surname'] ?? '';
            $maiden_name = $_POST['maiden_name'] ?? '';
            $name = $_POST['name'] ?? '';
            $fatherly = $_POST['fatherly'] ?? '';
            $birth_date = new DateTime($_POST['birth_date'] ?? '');
            $history = $_POST['history'] ?? '';

            $this->db->createRow($avatar_path, $photo_description, $surname, $maiden_name, $name, $fatherly, $birth_date, $history);

            header('Location: /');
        }
    }

    public function actionUpdate()
    {
        if ($_POST) {
            $photo_description = $_POST['file_description'];
            $surname = $_POST['surname'];
            $maiden_name = $_POST['maiden_name'];
            $name = $_POST['name'];
            $fatherly = $_POST['fatherly'];
            $birth_date= new DateTime($_POST['birth_date'] ?? '');
            $history = $_POST['history'];
            $id = $_POST['id'];

            $this->db->updateRow($id, $photo_description, $surname, $maiden_name, $name, $fatherly, $birth_date, $history);
        }
    }

    public function actionDelete()
    {
        if($_POST){
            $id = $_POST['id'];
        }

        $this->db->deleteRow($id);
    }
}

