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
    private $startTime = null;
    private $sql = null;
    private $params = null;

    private static $instance = null;
    private static $cache = [];

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

        file_put_contents("sql.log", $data = implode(PHP_EOL, $this->queries), FILE_APPEND);
    }

    public function beforeFunction()
    {
        $parentFunctionName = null;
        $arg = null;
        $backtrace = debug_backtrace();
        if (isset($backtrace[1])) {
            $parentFunctionName = $backtrace[1]['function'];
            $arg = $backtrace[1]['args'][0] ?? null;
        }

        if (isset(self::$cache[$parentFunctionName][$arg])) {
            return self::$cache[$parentFunctionName][$arg];
        }

        $this->startTime = microtime(true);
    }

    public function afterFunction(bool $isCache = false, $item = null)
    {
        $this->queries[] = $this->sql;
        $this->queries[] = json_encode($this->params);
        $this->queries[] = 'Query time: ' . round((microtime(true) - $this->startTime) * 1000, 2) . ' ms.';

        $this->sql = null;
        $this->params = null;
        $this->startTime = null;

        if (!$isCache) {
            return;
        }

        $parentFunctionName = null;
        $arg = null;
        $backtrace = debug_backtrace();
        if (isset($backtrace[1])) {
            $parentFunctionName = $backtrace[1]['function'];
            $arg = $backtrace[1]['args'][0] ?? 0;
        }

        return self::$cache[$parentFunctionName][$arg] = $item;
    }

    public function createRow($avatar_path, $surname, $maiden_name, $name, $fatherly, $birth_date, $history, $status, $death_date, $sex)
    {
        $this->beforeFunction();

        //перевірка на дубл:
        $this->sql = "SELECT * FROM family_members WHERE surname =:surname AND name =:name  AND fatherly =:fatherly";

        $stmt = $this->connection->prepare($this->sql);

        $this->params = [
            ':surname' => $surname,
            ':name' => $name,
            ':fatherly' => $fatherly,
        ];

        $stmt->execute($this->params);

        $exists = $stmt->fetchColumn(); // Повертає кількість записів

        if ($exists > 0) { // не дає створити дублюючий запис membera у бд
            $this->afterFunction();
            return;
        }

        // Якщо не існує - продовжуємо вставку
        $this->sql = "INSERT INTO family_members (avatar_path, surname, maiden_name, name, fatherly, birth_date,
                                              history, created_at, status, death_date, sex)
        VALUES (:avatar_path, :surname, :maiden_name, :name, :fatherly, :birth_date, :history, DEFAULT, :status, :death_date, :sex)";

        $stmt = $this->connection->prepare($this->sql);

        $this->params = [
            ':avatar_path' => $avatar_path,
            ':surname' => $surname,
            ':maiden_name' => $maiden_name,
            ':name' => $name,
            ':fatherly' => $fatherly,
            ':birth_date' => $birth_date->format('Y-m-d'), // передана відформатована дата, передаємо строку замість об'єкта
            ':history' => $history,
            ':status' => $status,
            ':death_date' => $death_date?->format('Y-m-d'), // передана відформатована дата, передаємо строку замість об'єкта
            ':sex' => $sex
        ];

        $stmt->execute($this->params);

        $this->afterFunction();
    }

    function getAllRows() //отримання усіх даних з таблиці
    {
        if($member = $this->beforeFunction()) {
            return $member;
        }

        $this->sql = "SELECT * FROM  family_members";
        $stmt = $this->connection->query($this->sql);

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->afterFunction(true, $res);

        return $res;
    }

    function getRowById($id) //отримання даних для редагування, отримання конкретного запису з БД для подальшого внесення змін.
    {
        if($member = $this->beforeFunction()) {
            return $member;
        }

        $this->sql = "SELECT * FROM family_members WHERE id=:id";
        $stmt = $this->connection->prepare($this->sql);

        $this->params = [
            ':id' => $id,
        ];

        $stmt->execute($this->params);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->afterFunction(true, $res);

        return $res;
    }

    function updateRow($id, $avatar_path, $surname, $maiden_name, $name, $fatherly, $birth_date, $history, $status, $death_date, $sex)
    {
        $this->beforeFunction();

        $this->sql = "UPDATE family_members SET avatar_path=:avatar_path, surname =:surname, maiden_name =:maiden_name,
                          name =:name, fatherly =:fatherly, birth_date=:birth_date, history =:history, status =:status, death_date =:death_date, sex =:sex WHERE id =:id"; //оновлення запису
        $stmt = $this->connection->prepare($this->sql);

        $this->params = [
            ':id' => $id,
            ':avatar_path' => $avatar_path,
            ':surname' => $surname,
            ':maiden_name' => $maiden_name,
            ':name' => $name,
            ':fatherly' => $fatherly,
            ':birth_date' => $birth_date->format('Y-m-d'), // передана відформатована дата, передаємо строку замість об'єкта
            ':history' => $history,
            ':status' => $status,
            ':death_date' => $death_date?->format('Y-m-d'),
            ':sex' => $sex
        ];

        $stmt->execute($this->params);

        $this->afterFunction();

        header('Location: /');
    }

    function deleteRow($id)
    {
        $this->beforeFunction();

        $this->sql = "DELETE FROM family_members WHERE id=:id";
        $stmt = $this->connection->prepare($this->sql);

        $this->params = [':id' => $id];

        $stmt->execute($this->params);

        $this->afterFunction();

        header('Location: /');
    }

    function createReletionship($member_id, $related_member_id, $relationship_type)
    {
        $this->beforeFunction();

        $this->sql = "INSERT INTO relationships (member_id, related_member_id, relationship_type) VALUES (:member_id, :related_member_id, :relationship_type)";
        $stmt = $this->connection->prepare($this->sql);

        $this->params = [
            ':member_id' => $member_id,
            ':related_member_id' => $related_member_id,
            ':relationship_type' => $relationship_type
        ];

        $stmt->execute($this->params);

        $this->afterFunction();

        header('Location: /');
    }

    function createCard($family_member_id, $image_path, $title, $description)
    {
        $this->beforeFunction();

        $this->sql = "INSERT INTO cards (family_member_id, image_path, title, description) VALUES (:family_member_id, :image_path, :title, :description)";
        $stmt = $this->connection->prepare($this->sql);
        $this->params = [
            ':family_member_id' => $family_member_id,
            ':image_path' => $image_path,
            ':title' => $title,
            ':description' => $description
        ];
        $stmt->execute($this->params);

        $this->afterFunction();

        header('Location: /');
    }

    function getAllCards() //отримання усіх карток
    {
        if($member = $this->beforeFunction()) {
            return $member;
        }

        $this->sql = "SELECT * FROM cards";
        $stmt = $this->connection->query($this->sql);

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->afterFunction(true, $res);

        return $res;
    }

    function getAllCardByIdMember($id)
    {
        if($member = $this->beforeFunction()) {
            return $member;
        }

        $this->sql = "SELECT * FROM cards WHERE family_member_id = :id";
        $stmt = $this->connection->prepare($this->sql);

        $this->params = [':id' => $id];
        $stmt->execute($this->params);

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->afterFunction(true, $res);

        return $res;
    }

    function getMemberById($id)
    {
        if($member = $this->beforeFunction()) {
            return $member;
        }

        $this->sql = "SELECT * FROM family_members WHERE id = :id";
        $stmt = $this->connection->prepare($this->sql);

        $this->params = [':id' => $id];
        $stmt->execute($this->params);

        $res = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->afterFunction(true, $res);

        return $res;
    }

    //відображення типу зв’язку ("мати", "батько" тощо) біля кожного члена родини
    function getFamilyRelationships($member_id = null, &$visited = [])
    {
        // Уникаємо нескінченних циклів
        if (in_array($member_id, $visited)) {
            return [];
        }

        if($member = $this->beforeFunction()) {
            return $member;
        }


        $visited[] = $member_id;

        $this->sql = "SELECT
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

        $stmt = $this->connection->prepare($this->sql);

        $this->params = [':member_id' => $member_id];

        $stmt->execute($this->params);
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

        $this->afterFunction(true, $result);

        return $result;
    }

    public function getParentsIdsByMemberId($memberId)
    {
        if($member = $this->beforeFunction()) {
            return $member;
        }


        $this->sql = "select related_member_id from relationships where member_id = :member_id and relationship_type = :relationship_type";
        $stmt = $this->connection->prepare($this->sql);

        $this->params = [
            ':member_id' => $memberId,
            ':relationship_type' => RoleRelationships::PARENT,
        ];

        $stmt->execute($this->params);

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->afterFunction(true, $res);

        return $res;
    }

    public function getChildrenIdsByParentId($parentId)
    {
        if($member = $this->beforeFunction()) {
            return $member;
        }

        $this->sql = "select member_id from relationships where related_member_id = :related_member_id and relationship_type = :relationship_type";
        $stmt = $this->connection->prepare($this->sql);

        $this->params = [
            ':related_member_id' => $parentId,
            ':relationship_type' => RoleRelationships::PARENT,
        ];

        $stmt->execute($this->params);

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->afterFunction(true, $res);

        return $res;
    }

    public function getPartnersIdsByMemberId($memberId)
    {
        if($member = $this->beforeFunction()) {
            return $member;
        }

        $this->sql = "select case when member_id = :member_id then related_member_id else member_id end as partner_id
                            from relationships
                            where (member_id = :member_id or related_member_id = :member_id)
                            and relationship_type = :relationship_type";
        $stmt = $this->connection->prepare($this->sql);

        $this->params = [
            ':member_id' => $memberId,
            ':relationship_type' => RoleRelationships::PARTNER,
        ];

        $stmt->execute($this->params);

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->afterFunction(true, $res);

        return $res;
    }

    public function getRelativesByNames($query)
    {
        if($member = $this->beforeFunction()) {
            return $member;
        }

        $this->sql = "SELECT * FROM family_members WHERE surname LIKE :query OR name LIKE :query OR maiden_name LIKE :query";
        $stmt = $this->connection->prepare($this->sql);

        $this->params = [':query' => '%' . $query . '%'];
        $stmt->execute($this->params);

        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->afterFunction(true, $res);

        return $res;
    }

    public function createUser($username, $userlastname, $login, $password)
    {
        $this->beforeFunction();

        $this->sql = "INSERT INTO users (username, userlastname, login, password) VALUES (:username, :userlastname, :login, :password)";

        $stmt = $this->connection->prepare($this->sql);

        $this->params = [
            ':username' => $username,
            ':userlastname' => $userlastname,
            ':login' => $login,
            ':password' => $password,

        ];

        $stmt->execute($this->params);

        $this->afterFunction();

    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}