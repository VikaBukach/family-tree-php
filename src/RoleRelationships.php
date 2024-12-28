<?php

namespace FamilyTree;

class RoleRelationships
{
    public const FATHER = 'FATHER';
    public const MOTHER = 'MOTHER';
    public const HUSBAND = 'HUSBAND';
    public const WIFE = 'WIFE';
    public const DAUGHTER = 'DAUGHTER';
    public const SON = 'SON';
    public const GRANDFATHER = 'GRANDFATHER';
    public const GRANDMOTHER = 'GRANDMOTHER';
    public const BROTHER = 'BROTHER';
    public const SISTER = 'SISTER';
    public const UNCLE = 'UNCLE';
    public const AUNTIE = 'AUNTIE';
    public const COUSINSISTER = 'COUSINSISTER';
    public const COUSINBROTHER = 'COUSINBROTHER';
    public const NIECE = 'NIECE';
    public const NEPHEW = 'NEPHEW';
    public const GRANDAUGHTER = 'GRANDAUGHTER';
    public const GRANDSON = 'GRANDSON';
    public const GREATGRANDFATHER = 'GREATGRANDFATHER';
    public const GREATGRANDMOTHER = 'GREATGRANDMOTHER';
    public const DAUGHTERINLAW = 'DAUGHTERINLAW'; //Невістка
    public const SONINLAW = 'SONINLAW';        //Зять
    public const MOTHERINLAW = 'MOTHERINLAW';  //Теща
    public const FATHERINLAW = 'FATHERINLAW';  //Тесть

    public static function getAllRoles()
    {
        return [
            self::FATHER => 'Батько',
            self::MOTHER => 'Мати',
            self::HUSBAND => 'Чоловік',
            self::WIFE => 'Дружина',
            self::DAUGHTER => 'Донька',
            self::SON => 'Син',
            self::GRANDFATHER => 'Дідусь',
            self::GRANDMOTHER => 'Бабуся',
            self::BROTHER => 'Брат',
            self::SISTER => 'Сестра',
            self::UNCLE => 'Дядько',
            self::AUNTIE => 'Тітка',
            self::COUSINSISTER => 'Двоюрідна сестра',
            self::COUSINBROTHER => 'Двоюрідний брат',
            self::NIECE => 'Племінниця',
            self::NEPHEW => 'Племіннник',
            self::GRANDAUGHTER => 'Онука',
            self::GRANDSON => 'Онук',
            self::GREATGRANDFATHER => 'Прадід',
            self::GREATGRANDMOTHER => 'Прабабка',
            self::DAUGHTERINLAW => 'Невістка',
            self::SONINLAW => ' Зять',
            self::MOTHERINLAW => 'свекровь',
            self::FATHERINLAW => 'тесть',
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