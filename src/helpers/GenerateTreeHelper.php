<?php

namespace FamilyTree\helpers;

use FamilyTree\entities\FamilyMember;

class GenerateTreeHelper
{
    private const DEPTH_VALUE = 100;

    private static $membersForTree = [];

    private static $circlesCount = self::DEPTH_VALUE;

    public static function getMembersForTree()
    {
        $resultTree = [];

        foreach (self::$membersForTree as $circles) {
            foreach ($circles as $member) {
                if (is_null($member)) {
                    continue;
                }

                $existingIds = array_column($resultTree, 'id');
                if (!in_array($member->getId(), $existingIds)) {
                    $resultTree[] = self::prepareMember($member);
                }
            }
        }

        return $resultTree;
    }

    public static function generate($member)
    {
        if (is_null($member)) {
            return self::$membersForTree;
        }

        $circle[] = $member;

        $partners = $member->getPartners();
        foreach ($partners as $partner) {
            $circle[] = $partner;
        }

        $sisters = $member->getSisters();
        foreach ($sisters as $sister) {
            $circle[] = $sister;
        }

        $brothers = $member->getBrothers();
        foreach ($brothers as $brother) {
            $circle[] = $brother;
        }

        $circle[] = $member->getFather();
        $circle[] = $member->getMother();

        $daughters = $member->getDaughters();
        foreach ($daughters as $daughter) {
            $circle[] = $daughter;
        }

        $sons = $member->getSons();
        foreach ($sons as $son) {
            $circle[] = $son;
        }

        self::$membersForTree[] = $circle;
    }

    public static function prepareMember(FamilyMember $member)
    {
        $result = [];

        $result['id'] = $member->getId();

        $result['pids'] = array_map(function (FamilyMember $member) {
            return $member->getId();
        }, $member->getPartners() ?: []);

        $result['title'] = $member->getFullName(); // прибрала name бо великий шифр
        $result['img'] = $member->getImagePath();
        $result['gender'] = $member->getSex();

        if (self::$circlesCount < 0) {
            $result['mid'] = null;
            $result['fid'] = null;
        } else {
            $result['mid'] = $member->getMother()?->getId();
            $result['fid'] = $member->getFather()?->getId();
        }

        return $result;
    }
}
