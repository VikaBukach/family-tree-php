<?php
namespace FamilyTree;

use FamilyTree\structure\FamilyRelationshipsStructure;
use PDO;
use PDOException;

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
            ':death_date' => $death_date?->format('Y-m-d') // передана відформатована дата, передаємо строку замість об'єкта
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

    function updateRow($id, $avatar_path, $photo_description, $surname, $maiden_name, $name, $fatherly, $birth_date, $history, $status, $death_date)
    {
        $sql = "UPDATE family_members SET avatar_path=:avatar_path, file_description =:file_description, surname =:surname, maiden_name =:maiden_name,
                          name =:name, fatherly =:fatherly, birth_date=:birth_date, history =:history, status =:status, death_date =:death_date WHERE id =:id"; //оновлення запису
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
            ':history' => $history,
            ':status' => $status,
            ':death_date' => $death_date?->format('Y-m-d')
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

    function getAllRoles() //отримання усіх ролей
    {
        $sql = "SELECT * FROM  roles";
        $stmt = $this->connection->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function createReletionship($member_id, $related_member_id, $relationship_type)
    {
        $sql = "INSERT INTO relationships (member_id, related_member_id, relationship_type) VALUES (:member_id, :related_member_id, :relationship_type)";
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
        ':member_id' => $member_id,
        ':related_member_id' => $related_member_id,
        ':relationship_type' => $relationship_type
        ]);
        header('Location: /');
    }

    function createCard($family_member_id, $image_path, $title, $description)
    {
        $sql = "INSERT INTO cards (family_member_id, image_path, title, description) VALUES (:family_member_id, :image_path, :title, :description)";
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
            ':family_member_id' => $family_member_id,
            ':image_path' => $image_path,
            ':title' => $title,
            ':description' => $description
        ]);
        header('Location: /');
    }

    function getAllCards() //отримання усіх карток
    {
        $sql = "SELECT * FROM cards";
        $stmt = $this->connection->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAllCardByIdMember($id)
    {
        $sql = "SELECT * FROM cards WHERE family_member_id = :id";
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([':id'=> $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getMemberById($id)
    {
        $sql = "SELECT * FROM family_members WHERE id = :id";
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([':id'=> $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //відображення типу зв’язку ("мати", "батько" тощо) біля кожного члена родини
    function getFamilyRelationships($member_id)
    {
        $sql= "SELECT
               fm.id as member_id,
               fm.name as memeber_name,
               fm.surname as memeber_surname,
               fm.avatar_path as memeber_avatar,
               rl.role_name AS role_name,
               fm2.name as related_name,
               fm2.surname as related_surname,
               fm2.avatar_path as related_avatar
            FROM family_members fm
                left join relationships r ON r.member_id = fm.id
                left join roles rl ON r.relationship_type = rl.id_role
                left join family_members fm2 ON r.related_member_id = fm2.id
            WHERE fm.id = :member_id";

    $stmt = $this->connection->prepare($sql);
    $stmt->execute([':member_id'=> $member_id]);
    $dataResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];
    foreach ($dataResult as $data) {
        $fr = new FamilyRelationshipsStructure(
            $data['member_id'],
            $data['memeber_name'],
            $data['memeber_surname'],
            $data['memeber_avatar'],
            $data['role_name'],
            $data['related_name'],
            $data['related_surname'],
            $data['related_avatar']
        );

        $result[] = $fr;
    }

    return $result;
    }
}