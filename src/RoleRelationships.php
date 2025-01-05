<?php

namespace FamilyTree;

class RoleRelationships
{
    public const FATHER = 'FATHER';
    public const MOTHER = 'MOTHER';
    public const PARTNER = 'PARTNER';

    public static function getAllRoles()
    {
        return [
            self::FATHER => 'Батько',
            self::MOTHER => 'Мати',
            self::PARTNER => 'Партнер'
        ];
    }

    public static function getNameByKey($roleKey)
    {
        if(array_key_exists($roleKey, self::getAllRoles())){
            return self::getAllRoles()[$roleKey];
        }

        return null;
    }

}