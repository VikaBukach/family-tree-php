<?php

require_once 'Db.php';

class Controller
{
    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }
    public function actionCreate() //view data from data base at page
    {

        if($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            $surname = $_POST['surname'] ?? '';
            $maiden_name = $_POST['maiden_name'] ?? '';
            $name = $_POST['name'] ?? '';
            $fatherly = $_POST['fatherly'] ?? '';
            $history = $_POST['history'] ?? '';

            echo "Прізвище: " . htmlspecialchars($surname) . "<br>";
            echo "Дівоче: " . htmlspecialchars($maiden_name) . "<br>";
            echo "Імʼя: " . htmlspecialchars($name) ."<br>";
            echo "По-батькові: " . htmlspecialchars($fatherly) ."<br>";
            echo "Історія: " . htmlspecialchars($history);

                $this->db->createRow($_POST);
        }
    }


}