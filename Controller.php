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
        if(method_exists($this, 'action', $actionName)){
            return $this->{'action' . $actionName}();
        }
    }

    public function actionCreate()
    {
        if($_POST) {
            $photo_description = $_POST['file_description'] ?? '';
            $surname = $_POST['surname'] ?? '';
            $maiden_name = $_POST['maiden_name'] ?? '';
            $name = $_POST['name'] ?? '';
            $fatherly = $_POST['fatherly'] ?? '';
            $history = $_POST['history'] ?? '';

            $this->db->createRow($photo_description, $surname, $maiden_name, $name, $fatherly, $history);

            header('Location: /');
        }
    }


}