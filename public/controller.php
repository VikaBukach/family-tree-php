<?php

require_once '../Db.php';

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

            if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK){
              $uploadDir = __DIR__ . '/img/';   // Директорія для збереження аватарів
              $fileName = uniqid() . '-' . basename($_FILES['avatar']['name']);
              $filePath = $uploadDir . $fileName;

              if(move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath)){
                  $avatar_path = '/img/' . $fileName; // Шлях до аватара
              }
            }

            $photo_description = $_POST['file_description'] ?? '';
            $surname = $_POST['surname'] ?? '';
            $maiden_name = $_POST['maiden_name'] ?? '';
            $name = $_POST['name'] ?? '';
            $fatherly = $_POST['fatherly'] ?? '';
            $birth_date = new DateTime($_POST['birth_date'] ?? '');
            $history = $_POST['history'] ?? '';
            $status = $_POST['status'] ?? '';
            $death_date = !empty($_POST['death_date']) ? new DateTime($_POST['death_date']) : null;

            $this->db->createRow($avatar_path, $photo_description, $surname, $maiden_name, $name, $fatherly, $birth_date, $history, $status, $death_date);

            header('Location: /');
        }
    }

    public function actionUpdate()
    {
        if ($_POST) {

            $avatar_path = $_POST['avatar_path'] ?? '';

            if(isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK){
                $uploadDir = __DIR__ . '/img/';   // Директорія для збереження аватарів
                $fileName = uniqid() . '-' . basename($_FILES['avatar']['name']);
                $filePath = $uploadDir . $fileName;

                if(move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath)){
                    $avatar_path = '/img/' . $fileName; // Шлях до аватара
                }
            }

            $photo_description = $_POST['file_description'];
            $surname = $_POST['surname'];
            $maiden_name = $_POST['maiden_name'];
            $name = $_POST['name'];
            $fatherly = $_POST['fatherly'];
            $birth_date= new DateTime($_POST['birth_date'] ?? '');
            $history = $_POST['history'];
            $status = $_POST['status'];
            $death_date = !empty($_POST['death_date']) ? new DateTime($_POST['death_date']) : null;
            $id = $_POST['id'];

            $this->db->updateRow($id, $avatar_path, $photo_description, $surname, $maiden_name, $name, $fatherly, $birth_date, $history, $status, $death_date);
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

$controller = new Controller();
$controller->runAction($_GET['action'] ?? '');