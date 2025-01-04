<?php

namespace FamilyTree\helpers;

use FamilyTree\Db;
use FamilyTree\entities\FamilyMember;
use RuntimeException;

class FamilyMemberHelper
{
    public static function initMember($id)
    {
       $db = Db::getInstance();

        if(!$familyMember = $db->getMemberById($id)) {
            throw new RuntimeException('Member does not found');
        }

        $familyMemberEntity = new FamilyMember(
            $familyMember['id'],
            $familyMember['avatar_path'],
            $familyMember['file_description'],
            $familyMember['surname'],
            $familyMember['maiden_name'],
            $familyMember['name'],
            $familyMember['fatherly'],
            $familyMember['birth_date'],
            $familyMember['history'],
            $familyMember['created_at'],
            $familyMember['status'],
            $familyMember['death_date'],
            $familyMember['sex']
        );

        return $familyMemberEntity;
    }
}