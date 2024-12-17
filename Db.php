<?php
require_once 'env.php';

class Db
{
    public $connection;

    public function __construct()
    {
        $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4';
        $username = DB_USER;
        $pass = DB_PASS;

        try {
            $this->connection = new PDO($dsn, $username, $pass);
        } catch (PDOException $exception) {
            echo "Error connecting: " . $exception->getMessage();
        }
    }

    public function createRow($photo_description, $surname, $maiden_name, $name, $fatherly, $history) // добавление записи в БД
    {
        $sql = "INSERT INTO family_members (file_description, surname, maiden_name, name, fatherly, history) VALUES (:file_description, :surname, :maiden_name, :name, :fatherly, :history)";
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
            ':file_description' => $photo_description,
            ':surname' => $surname,
            ':maiden_name' => $maiden_name,
            ':name' => $name,
            ':fatherly' => $fatherly,
            ':history' => $history
        ]);
    }

    function getAllRows() //отримання усіх даних з таблиці
    {
        $sql = "SELECT * FROM  family_members";
        $stmt = $this->connection->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getRowById($id) //отримання даних для редагування, отримання конкретного запису з БД для подальшого внесення змін.
    {
        $sql = "SELECT * FROM family_members WHERE id=:id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':id' => $id,
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateRow($id, $photo_description, $surname, $maiden_name, $name, $fatherly, $history)
    {
        $sql = "UPDATE family_members SET file_description =:file_description, surname =:surname, maiden_name =:maiden_name, name =:name, fatherly =:fatherly, history =:history WHERE id =:id"; //оновлення запису
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
            ':id'=> $id,
            ':file_description'=> $photo_description,
            ':surname'=> $surname,
            ':maiden_name'=> $maiden_name,
            ':name'=> $name,
            ':fatherly'=> $fatherly,
            ':history'=> $history,
        ]);
        header('Location: /');
    }


}