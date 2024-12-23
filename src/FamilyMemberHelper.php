<?php

namespace FamilyTree;

use FamilyTree\entity\FamilyMember;

class FamilyMemberHelper
{
    public static function initMembers($id)
    {
       $db = new Db();

        $familyMember = $db->getMemberById($id);

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