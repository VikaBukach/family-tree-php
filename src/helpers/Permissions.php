<?php

namespace FamilyTree\helpers;

class Permissions
{
    const PERMISSION = [
        'create' => ['admin', 'user'],
        'update' => ['admin', 'user'],
        'delete' => ['admin'],
        'view' => ['admin', 'user', 'viewer'],
    ];

    public static function hasAccess($action, $role)
    {
        if(!isset(self::PERMISSION[$action])){
            die("Дія '{$action}' не знайдена в списку дозволів");
        }

        $allowedRoles = self::PERMISSION[$action];

        return in_array($role, $allowedRoles);
    }

}