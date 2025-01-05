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
        $this->db = Db::getInstance();
    }

    public function getId()
    {
        return $this->id;
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

    public function getSisters()
    {
        $sisters = [];

        $relatedMembers = $this->db->getRelatedMemberIdsByMemberAndRoleName($this->id, RoleRelationships::SISTER);

        if(!$relatedMembers){
            return $sisters;
        }

        foreach ($relatedMembers as $relatedMember){
            $sisters[]= FamilyMemberHelper::initMember($relatedMember['related_member_id']);
        }

        return $sisters;
    }

    public function getBrothers()
    {
        $brothers = [];

        $relatedMembers = $this->db->getRelatedMemberIdsByMemberAndRoleName($this->id, RoleRelationships::BROTHER);

        if(!$relatedMembers){
            return $brothers;
        }

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
        $sons = [];

        $relatedMembers = $this->db->getRelatedMemberIdsByMemberAndRoleName($this->id, RoleRelationships::SON);

        if(!$relatedMembers){
            return $sons;
        }

        foreach ($relatedMembers as $relatedMember){
            $sons[]= FamilyMemberHelper::initMember($relatedMember['related_member_id']);
        }

        return $sons;
    }

    public function getDaughters()
    {
        $daughters = [];

        $relatedMembers = $this->db->getRelatedMemberIdsByMemberAndRoleName($this->id, RoleRelationships::DAUGHTER);

        if(!$relatedMembers){
            return $daughters;
        }

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