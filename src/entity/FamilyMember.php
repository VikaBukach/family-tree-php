<?php

namespace FamilyTree\entity;

use FamilyTree\Db;
use FamilyTree\FamilyMemberHelper;

class FamilyMember
{
    private const HUSBAND = 'Чоловік';
    private const WIFE = 'Дружина';
    private const MOTHER = 'Мати';
    private const FATHER = 'Батько';

    private $db;

    public function __construct(
        private $id,
        private $avatar_path,
        private $file_description,
        private $surname,
        private $maiden_name,
        private $name,
        private $fatherly,
        private $birth_date,
        private $history,
        private $created_at,
        private $status,
        private $death_date,
        private $sex
    ) {
        $this->db = new Db();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getPartner()
    {
        $currentPartner = $this->sex == 1 ? self::HUSBAND : self::WIFE;

        $relatedMember = $this->db->getRelatedMemberIdByMemberAndRoleName($this->id, $currentPartner);

        if(!$relatedMember){
            return null;
        }

        return FamilyMemberHelper::initMembers($relatedMember['related_member_id']);
    }

    public function getFullName()
    {
        return $this->name . ' ' . $this->surname;
    }

    public function getImagePath()
    {
        return $this->avatar_path;
    }

    public function getSex()
    {
        return $this->sex == 1 ? 'female' : 'male';
    }

    public function getMother()
    {
        $relatedMember = $this->db->getRelatedMemberIdByMemberAndRoleName($this->id, self::MOTHER);

        if(!$relatedMember){
            return null;
        }

        return FamilyMemberHelper::initMembers($relatedMember['related_member_id']);
    }

    public function getFather()
    {
        $relatedMember = $this->db->getRelatedMemberIdByMemberAndRoleName($this->id, self::FATHER);

        if(!$relatedMember){
            return null;
        }

        return FamilyMemberHelper::initMembers($relatedMember['related_member_id']);
    }
}