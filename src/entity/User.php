<?php
namespace FamilyTree\entity;

use FamilyTree\Db;

class User
{
    public const SEX_MALE = 0;
    public const SEX_FEMALE = 1;

    private $db;

    public function __construct()
    {
        $this->db = new Db();
    }

    public function isMale(): bool
    {
        return $this->sex === self::SEX_MALE;
    }

    public function getAllParents(): array
    {
        return $this->db->getParentsByUserId($this->id);
    }
}