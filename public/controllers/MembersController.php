<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use FamilyTree\BaseController;
use FamilyTree\RoleRelationships;

class MembersController extends BaseController
{
    public function actionCreate()
    {
        $this->checkAccess('create');

        if ($_POST) {
            // Обробка аватара
            $avatar_path = '';

            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../img/';   // Директорія для збереження аватарів
                $fileName = uniqid() . '-' . basename($_FILES['avatar']['name']);
                $filePath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath)) {
                    $avatar_path = '/../img/' . $fileName; // Шлях до аватара
                }
            }

            // Обробка інш
            $surname = $_POST['surname'] ?? '';
            $maiden_name = $_POST['maiden_name'] ?? '';
            $name = $_POST['name'] ?? '';
            $fatherly = $_POST['fatherly'] ?? '';
            $birth_date = new DateTime($_POST['birth_date'] ?? '');
            $history = $_POST['history'] ?? '';
            $status = $_POST['status'] ?? '';
            $death_date = !empty($_POST['death_date']) ? new DateTime($_POST['death_date']) : null;
            $sex = $_POST['sex'] ?? '';

            $this->db->createRow($avatar_path, $surname, $maiden_name, $name, $fatherly, $birth_date, $history, $status, $death_date, $sex);

            header('Location: /');
        }
    }

    public function actionUpdate()
    {
        $this->checkAccess('update');

        if ($_POST) {

            $avatar_path = $_POST['avatar_path'] ?? '';

            // Перевірка та завантаження нового файлу
            if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../img/';   // Директорія для збереження аватарів
                $fileName = uniqid() . '-' . basename($_FILES['avatar']['name']);
                $filePath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['avatar']['tmp_name'], $filePath)) {
                    // Видалення старого аватара
                  if(!empty($avatar_path) && file_exists(__DIR__ . $avatar_path)){
                      unlink(__DIR__ . $avatar_path);
                  }
                }

                $avatar_path = '/../img/' . $fileName; // Шлях до аватара
            }

            $surname = $_POST['surname'];
            $maiden_name = $_POST['maiden_name'];
            $name = $_POST['name'];
            $fatherly = $_POST['fatherly'];
            $birth_date = new DateTime($_POST['birth_date'] ?? '');
            $history = $_POST['history'];
            $status = $_POST['status'];
            $death_date = !empty($_POST['death_date']) ? new DateTime($_POST['death_date']) : null;
            $sex = $_POST['sex'];
            $id = $_POST['id'];

            $this->db->updateRow($id, $avatar_path, $surname, $maiden_name, $name, $fatherly, $birth_date, $history, $status, $death_date, $sex);
        }
    }

    public function actionDelete()
    {
        $this->checkAccess('delete');

        if ($_POST) {
            $id = $_POST['id'];
        }

        $this->db->deleteRow($id);

        header('Location: /');
    }

    public function actionGetMembersByType()
    {
        if (!empty($_GET['memberId']) && !empty($_GET['type'])) {
            $memberId = $_GET['memberId'];
            $type = $_GET['type'];

            $res = [];
            if ($type === RoleRelationships::PARENT) {
                $res = $this->db->getAvailableMembersAsParent($memberId);
            } else if ($type === RoleRelationships::PARTNER) {
                $res = $this->db->getAvailableMembersAsPartner($memberId);
            }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($res);
        }
    }

}

$controller = new MembersController();
$controller->runAction($_GET['action'] ?? '');