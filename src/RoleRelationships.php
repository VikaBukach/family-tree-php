<?php

namespace FamilyTree;

class RoleRelationships
{
    public const PARENT = 'PARENT';
    public const PARTNER = 'PARTNER';
    public const CHILD = 'CHILD';

    public static function getAllRoles()
    {
        return [
            self::PARENT => 'Один з батьків',
            self::PARTNER => 'Партнер',
            self::CHILD => 'Дитина',
        ];
    }

    public static function getNameByKey($roleKey)
    {
        if (array_key_exists($roleKey, self::getAllRoles())) {
            return self::getAllRoles()[$roleKey];
        }

        return null;
    }

}