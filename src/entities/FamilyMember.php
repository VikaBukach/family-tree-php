<?php

namespace FamilyTree\entities;

use FamilyTree\Db;
use FamilyTree\helpers\FamilyMemberHelper;
use FamilyTree\RoleRelationships;

class FamilyMember
{
    private $db;

    public function __construct(
        private $id,
        private $avatar_path,
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
        $this->db = Db::getInstance();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getParents()
    {
        $parents = [];

        $relatedMembers = $this->db->getParentsIdsByMemberId($this->id);

        if(!$relatedMembers){
            return $parents;
        }

        foreach ($relatedMembers as $relatedMember){
            $parents[]= FamilyMemberHelper::initMember($relatedMember['related_member_id']);
        }

        return $parents;
    }

    public function getPartners()
    {
        $partners = [];

        $relatedMembers = $this->db->getPartnersIdsByMemberId($this->id);

        if(!$relatedMembers){
            return $partners;
        }

        foreach ($relatedMembers as $relatedMember){
            $partners[]= FamilyMemberHelper::initMember($relatedMember['partner_id']);
        }

        return $partners;
    }
    public function getChildren()
    {
        $children = [];

        $relatedMembers = $this->db->getChildrenIdsByParentId($this->id);

        if(!$relatedMembers){
            return $children;
        }

        foreach ($relatedMembers as $relatedMember){
            $children[]= FamilyMemberHelper::initMember($relatedMember['member_id']);
        }

        return $children;
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

}