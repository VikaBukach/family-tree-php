<?php

namespace FamilyTree\helpers;

use FamilyTree\entities\FamilyMember;

class GenerateTreeHelper
{
    private static $result = [];

    public static function getResult()
    {
        return self::$result;
    }

    public static function generate($memberId)
    {
        $member = FamilyMemberHelper::initMember($memberId);

        if (is_null($member)) {
            return self::$result;
        }

        $existingIds = array_column(self::$result, 'id');
        if (!in_array($member->getId(), $existingIds)) {
            self::$result[] = self::prepareMember($member);
        }


        $partners = $member->getPartners();
        foreach ($partners as $partner) {
            $existingIds = array_column(self::$result, 'id');
            if (!in_array($partner->getId(), $existingIds)) {
                self::$result[] = self::prepareMember($partner);
            }
        }

        $sisters = $member->getSisters();
        foreach ($sisters as $sister) {
            $existingIds = array_column(self::$result, 'id');
            if (!in_array($sister->getId(), $existingIds)) {
                self::$result[] = self::prepareMember($sister);
            }
        }

        $brothers = $member->getBrothers();
        foreach ($brothers as $brother) {
            $existingIds = array_column(self::$result, 'id');
            if (!in_array($brother->getId(), $existingIds)) {
                self::$result[] = self::prepareMember($brother);
            }
        }

        $father = $member->getFather();
        $existingIds = array_column(self::$result, 'id');
        if ($father && !in_array($father->getId(), $existingIds)) {
            self::$result[] = self::prepareMember($father);
            if ($grandFather = $father->getFather()) {
                self::generate($grandFather->getId());
            }
        }

        $mother = $member->getMother();
        $existingIds = array_column(self::$result, 'id');
        if ($mother && !in_array($mother->getId(), $existingIds)) {
            self::$result[] = self::prepareMember($mother);
            if ($grandMother = $father->getMother()) {
                self::generate($grandMother->getId());
            }
        }

        $daughters = $member->getDaughters();
        foreach ($daughters as $daughter) {
            $existingIds = array_column(self::$result, 'id');
            if (!in_array($daughter->getId(), $existingIds)) {
                self::$result[] = self::prepareMember($daughter);
            }
        }

        $sons = $member->getSons();
        foreach ($sons as $son) {
            $existingIds = array_column(self::$result, 'id');
            if (!in_array($son->getId(), $existingIds)) {
                self::$result[] = self::prepareMember($son);
            }
        }
    }

    public static function prepareMember(FamilyMember $member)
    {
        $result = [];

        $result['id'] = $member->getId();

        $result['pids'] = array_map(function (FamilyMember $member){
            return $member->getId();
        }, $member->getPartners() ?: []);

        $result['title'] = $member->getFullName(); // прибрала name бо великий шифр
        $result['img'] = $member->getImagePath();
        $result['gender'] = $member->getSex();
//    $result['title'] = ;

        $result['mid'] = $member->getMother()?->getId();
        $result['fid'] = $member->getFather()?->getId();


        return $result;
    }

}