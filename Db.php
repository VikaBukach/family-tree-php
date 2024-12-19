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

    public function createRow($avatar_path, $photo_description, $surname, $maiden_name, $name, $fatherly, $birth_date, $history, $status, $death_date)
    {
        $sql = "INSERT INTO family_members (avatar_path, file_description, surname, maiden_name, name, fatherly, birth_date,
                                              history, created_at, status, death_date)
        VALUES (:avatar_path, :file_description, :surname, :maiden_name, :name, :fatherly, :birth_date, :history, DEFAULT, :status, :death_date)";

        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
            ':avatar_path' => $avatar_path,

            ':file_description' => $photo_description,
            ':surname' => $surname,
            ':maiden_name' => $maiden_name,
            ':name' => $name,
            ':fatherly' => $fatherly,
            ':birth_date' => $birth_date->format('Y-m-d'), // передана відформатована дата, передаємо строку замість об'єкта
            ':history' => $history,
            ':status' => $status,
            ':death_date' => $death_date->format('Y-m-d') // передана відформатована дата, передаємо строку замість об'єкта
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

    function updateRow($id, $avatar_path, $photo_description, $surname, $maiden_name, $name, $fatherly, $birth_date, $history)
    {
        $sql = "UPDATE family_members SET avatar_path=:avatar_path, file_description =:file_description, surname =:surname, maiden_name =:maiden_name,
                          name =:name, fatherly =:fatherly, birth_date=:birth_date, history =:history WHERE id =:id"; //оновлення запису
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
            ':id'=> $id,
            ':avatar_path'=> $avatar_path,
            ':file_description' => $photo_description,
            ':surname' => $surname,
            ':maiden_name' => $maiden_name,
            ':name' => $name,
            ':fatherly' => $fatherly,
            ':birth_date' => $birth_date->format('Y-m-d'), // передана відформатована дата, передаємо строку замість об'єкта
            ':history' => $history
        ]);
        header('Location: /');
    }

    function deleteRow($id)
    {
        $sql = "DELETE FROM family_members WHERE id=:id";
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id'=> $id]);

        header('Location: /');

    }


}