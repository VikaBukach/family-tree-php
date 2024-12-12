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

    public function createFamilyMembersTable()
    {
        $sql = "create table family_members
    (
    id int auto_increment primary key,
    surname          varchar(55)                         null,
    maiden_name      varchar(55)                         null,
    name             varchar(55)                         null,
    fatherly         varchar(55)                         null,
    history          text                                null,
    created_at       timestamp default CURRENT_TIMESTAMP null
)";

        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
    }

//    public function createFamilyMembersTable()
//    {
//        $sql = "create table family_members
//    (
//        id               int auto_increment
//        primary key,
//    file_path        varchar(255)                        null,
//    file_description varchar(255)                        null,
//    surname          varchar(55)                         null,
//    maiden_name      varchar(55)                         null,
//    name             varchar(55)                         null,
//    fatherly         varchar(55)                         null,
//    birth_date       date                                null,
//    death_date       date                                null,
//    history          text                                null,
//    created_at       timestamp default CURRENT_TIMESTAMP null
//)";
//
//        $stmt = $this->connection->prepare($sql);
//        $stmt->execute();
//    }

    public function createRow($data)
    {
        $sql = "INSERT INTO family_members(surname, maiden_name, name, fatherly, history) VALUES (:surname, :maiden_name, :name, :fatherly, :history)";
        $stmt = $this->connection->prepare($sql);

        $dataInsert = [
            ':surname' => $data['surname'],
            ':maiden_name' => $data['maiden_name'],
            ':name' => $data['name'],
            ':fatherly' => $data['fatherly'],
            ':history' => $data['history'],
        ];

        $stmt->execute($dataInsert);
    }


}