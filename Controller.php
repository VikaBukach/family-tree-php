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

    public function actionCreate()  // создание записи в БД
    {
        if($_POST) {
            $photo_description = $_POST['file_description'] ?? '';
            $surname = $_POST['surname'] ?? '';
            $maiden_name = $_POST['maiden_name'] ?? '';
            $name = $_POST['name'] ?? '';
            $fatherly = $_POST['fatherly'] ?? '';
            $birth_date = new DateTime($_POST['birth_date'] ?? '');
            $history = $_POST['history'] ?? '';

            $this->db->createRow($photo_description, $surname, $maiden_name, $name, $fatherly, $birth_date, $history);

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

