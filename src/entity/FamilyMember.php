<?php

namespace FamilyTree\entity;

use FamilyTree\Db;
use FamilyTree\FamilyMemberHelper;
use FamilyTree\RoleRelationships;

class FamilyMember
{
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

    public function getPartners()
    {
        $currentPartner = $this->sex == 1 ? RoleRelationships::HUSBAND : RoleRelationships::WIFE;

        $relatedMembers = $this->db->getRelatedMemberIdsByMemberAndRoleName($this->id, $currentPartner);

        if(!$relatedMembers){
            return null;
        }

        $partners = [];

        foreach ($relatedMembers as $relatedMember){
            $partners[]= FamilyMemberHelper::initMember($relatedMember['related_member_id']);
        }

        return $partners;
    }

    public function getSisters()
    {
        $relatedMembers = $this->db->getRelatedMemberIdsByMemberAndRoleName($this->id, RoleRelationships::SISTER);

        if(!$relatedMembers){
            return null;
        }

        $sisters = [];

        foreach ($relatedMembers as $relatedMember){
            $sisters[]= FamilyMemberHelper::initMember($relatedMember['related_member_id']);
        }

        return $sisters;
    }

    public function getBrothers()
    {
        $relatedMembers = $this->db->getRelatedMemberIdsByMemberAndRoleName($this->id, RoleRelationships::BROTHER);

        if(!$relatedMembers){
            return null;
        }

        $brothers = [];

        foreach ($relatedMembers as $relatedMember){
            $brothers[]= FamilyMemberHelper::initMember($relatedMember['related_member_id']);
        }

        return $brothers;
    }

    public function getMother()
    {
        $relatedMember = $this->db->getRelatedMemberIdByMemberAndRoleName($this->id, RoleRelationships::MOTHER);

        if(!$relatedMember){
            return null;
        }

        return FamilyMemberHelper::initMember($relatedMember['related_member_id']);
    }

    public function getFather()
    {
        $relatedMember = $this->db->getRelatedMemberIdByMemberAndRoleName($this->id, RoleRelationships::FATHER);

        if(!$relatedMember){
            return null;
        }

        return FamilyMemberHelper::initMember($relatedMember['related_member_id']);
    }

    public function getSons()
    {
        $relatedMembers = $this->db->getRelatedMemberIdsByMemberAndRoleName($this->id, RoleRelationships::SON);

        if(!$relatedMembers){
            return null;
        }

        $sons = [];

        foreach ($relatedMembers as $relatedMember){
            $sons[]= FamilyMemberHelper::initMember($relatedMember['related_member_id']);
        }

        return $sons;
    }

    public function getDaughters()
    {
        $relatedMembers = $this->db->getRelatedMemberIdsByMemberAndRoleName($this->id, RoleRelationships::DAUGHTER);

        if(!$relatedMembers){
            return null;
        }

        $daughters = [];

        foreach ($relatedMembers as $relatedMember){
            $daughters[]= FamilyMemberHelper::initMember($relatedMember['related_member_id']);
        }

        return $daughters;
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