<?php

namespace FamilyTree;

use DateTime;
use FamilyTree\structures\FamilyRelationshipsStructure;
use PDO;
use PDOException;

require_once 'env.php';

class Db
{
    public $connection;

    private $queries = [];

    private static $instance = null;

    private function __construct()
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

    public function __destruct()
    {
        $startString = "\n========================================= " . (new DateTime())->format('Y-m-d H:i:s.u') . " =========================================\n";
        file_put_contents("sql.log", $startString, FILE_APPEND);

        file_put_contents("sql.log", $this->queries, FILE_APPEND);
    }

    public function createRow($avatar_path, $photo_description, $surname, $maiden_name, $name, $fatherly, $birth_date, $history, $status, $death_date, $sex)
    {
        //перевірка на дубл:
        $sql = "SELECT * FROM family_members WHERE surname =:surname AND name =:name  AND fatherly =:fatherly";
        $this->queries[] = $sql;
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
            ':surname' => $surname,
            ':name' => $name,
            ':fatherly' => $fatherly,
        ]);

        $exists = $stmt->fetchColumn(); // Повертає кількість записів

        if ($exists > 0) { // не дає створити дублюючий запис membera у бд
            return;
        }

        // Якщо не існує - продовжуємо вставку
        $sql = "INSERT INTO family_members (avatar_path, file_description, surname, maiden_name, name, fatherly, birth_date,
                                              history, created_at, status, death_date, sex)
        VALUES (:avatar_path, :file_description, :surname, :maiden_name, :name, :fatherly, :birth_date, :history, DEFAULT, :status, :death_date, :sex)";
        $this->queries[] = $sql;

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
            ':death_date' => $death_date?->format('Y-m-d'), // передана відформатована дата, передаємо строку замість об'єкта
            ':sex' => $sex
        ]);
    }

    function getAllRows() //отримання усіх даних з таблиці
    {
        $sql = "SELECT * FROM  family_members";
        $this->queries[] = $sql;
        $stmt = $this->connection->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getRowById($id) //отримання даних для редагування, отримання конкретного запису з БД для подальшого внесення змін.
    {
        $sql = "SELECT * FROM family_members WHERE id=:id";
        $this->queries[] = $sql;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':id' => $id,
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function updateRow($id, $avatar_path, $photo_description, $surname, $maiden_name, $name, $fatherly, $birth_date, $history, $status, $death_date, $sex)
    {
        $sql = "UPDATE family_members SET avatar_path=:avatar_path, file_description =:file_description, surname =:surname, maiden_name =:maiden_name,
                          name =:name, fatherly =:fatherly, birth_date=:birth_date, history =:history, status =:status, death_date =:death_date, sex =:sex WHERE id =:id"; //оновлення запису
        $this->queries[] = $sql;
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([
            ':id' => $id,
            ':avatar_path' => $avatar_path,
            ':file_description' => $photo_description,
            ':surname' => $surname,
            ':maiden_name' => $maiden_name,
            ':name' => $name,
            ':fatherly' => $fatherly,
            ':birth_date' => $birth_date->format('Y-m-d'), // передана відформатована дата, передаємо строку замість об'єкта
            ':history' => $history,
            ':status' => $status,
            ':death_date' => $death_date?->format('Y-m-d'),
            ':sex' => $sex
        ]);
        header('Location: /');
    }

    function deleteRow($id)
    {
        $sql = "DELETE FROM family_members WHERE id=:id";
        $this->queries[] = $sql;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':id' => $id]);

        header('Location: /');
    }

    function createReletionship($member_id, $related_member_id, $relationship_type)
    {
        $sql = "INSERT INTO relationships (member_id, related_member_id, relationship_type) VALUES (:member_id, :related_member_id, :relationship_type)";
        $this->queries[] = $sql;
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
        $this->queries[] = $sql;
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
        $this->queries[] = $sql;
        $stmt = $this->connection->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAllCardByIdMember($id)
    {
        $sql = "SELECT * FROM cards WHERE family_member_id = :id";
        $this->queries[] = $sql;
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([':id' => $id]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getMemberById($id)
    {
        $sql = "SELECT * FROM family_members WHERE id = :id";
        $this->queries[] = $sql;
        $stmt = $this->connection->prepare($sql);

        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //відображення типу зв’язку ("мати", "батько" тощо) біля кожного члена родини
    function getFamilyRelationships($member_id = null, &$visited = [])
    {
        // Уникаємо нескінченних циклів
        if (in_array($member_id, $visited)) {
            return [];
        }

        $visited[] = $member_id;

        $sql = "SELECT
               fm.id as member_id,
               fm.name as memeber_name,
               fm.surname as memeber_surname,
               fm.avatar_path as memeber_avatar,
               r.relationship_type AS role_type,
               fm2.name as related_name,
               fm2.surname as related_surname,
               fm2.avatar_path as related_avatar
            FROM family_members fm
                left join relationships r ON r.member_id = fm.id
                left join family_members fm2 ON r.related_member_id = fm2.id
            WHERE fm.id = :member_id";

        $this->queries[] = $sql;

        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':member_id' => $member_id]);
        $dataResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $result = [];
        foreach ($dataResult as $data) {
            $result[] = new FamilyRelationshipsStructure(
                $data['member_id'],
                $data['memeber_name'],
                $data['memeber_surname'],
                $data['memeber_avatar'],
                $data['role_type'],
                $data['related_name'],
                $data['related_surname'],
                $data['related_avatar']
            );
        }

        return $result;
    }

    public function getRelatedMemberIdByMemberAndRoleName($memberId, $roleType)
    {
        $sql = "SELECT related_member_id FROM relationships WHERE member_id = :member_id AND relationship_type = :relationship_type";
        $this->queries[] = $sql;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':member_id' => $memberId,
            ':relationship_type' => $roleType
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRelatedMemberIdsByMemberAndRoleName($memberId, $roleType)
    {
        $sql = "SELECT related_member_id FROM relationships WHERE member_id = :member_id AND relationship_type = :relationship_type";
        $this->queries[] = $sql;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([
            ':member_id' => $memberId,
            ':relationship_type' => $roleType
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRelativesByNames($query)
    {
        $sql = "SELECT * FROM family_members WHERE surname LIKE :query OR name LIKE :query OR maiden_name LIKE :query";
        $this->queries[] = $sql;
        $stmt = $this->connection->prepare($sql);
        $stmt->execute([':query' => '%' . $query . '%']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}