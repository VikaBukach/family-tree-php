<?php

namespace FamilyTree\helpers;

use FamilyTree\entities\FamilyMember;

class GenerateTreeHelper
{
    private const DEPTH_VALUE = 2;

    private static $membersForTree = [];
    private static $currentCircle = 0;

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

        $allIds = array_column($resultTree, 'id');

        foreach ($resultTree as $key => $item) {
            if (!empty($item['mid']) && !in_array($item['mid'], $allIds)) {
                $resultTree[$key]['mid'] = null;
            }

            if (!empty($item['fid']) && !in_array($item['fid'], $allIds)) {
                $resultTree[$key]['fid'] = null;
            }

            foreach ($item['pids'] as $keyp => $pid) {
                if (!in_array($pid, $allIds)) {
                    unset($resultTree[$key]['pids'][$keyp]);
                }
            }
        }

        return $resultTree;
    }

    public static function generateStart(FamilyMember $member)
    {
        self::generate($member);

        for ($i = 1; $i < self::DEPTH_VALUE; $i++) {
            self::$currentCircle = $i;
            if (key_exists(self::$currentCircle-1, self::$membersForTree)) {
                foreach (self::$membersForTree as $circle) {
                    /** @var FamilyMember  $memberOfCircle */
                    foreach ($circle as $memberOfCircle) {
                        if ($memberOfCircle->getId() === $member->getId()) {
                            continue;
                        }

                        self::generate($memberOfCircle);
                    }
                }
            }
        }
    }

    private static function generate(?FamilyMember $member)
    {
        if (is_null($member)) {
            return self::$membersForTree;
        }

        self::$membersForTree[self::$currentCircle][] = $member;

        $partners = $member->getPartners();
        foreach ($partners as $partner) {
            self::$membersForTree[self::$currentCircle][] = $partner;
        }

        $sisters = $member->getSisters();
        foreach ($sisters as $sister) {
            self::$membersForTree[self::$currentCircle][] = $sister;
        }

        $brothers = $member->getBrothers();
        foreach ($brothers as $brother) {
            self::$membersForTree[self::$currentCircle][] = $brother;
        }

        self::$membersForTree[self::$currentCircle][] = $member->getFather();
        self::$membersForTree[self::$currentCircle][] = $member->getMother();

        $daughters = $member->getDaughters();
        foreach ($daughters as $daughter) {
            self::$membersForTree[self::$currentCircle][] = $daughter;
        }

        $sons = $member->getSons();
        foreach ($sons as $son) {
            self::$membersForTree[self::$currentCircle][] = $son;
        }
    }

    public static function prepareMember(FamilyMember $member)
    {
        $result = [];

        $result['id'] = $member->getId();

        $result['title'] = $member->getFullName(); // прибрала name бо великий шрифт
        $result['img'] = $member->getImagePath();
        $result['gender'] = $member->getSex();

        $result['pids'] = array_map(function (FamilyMember $member) {
            return $member->getId();
        }, $member->getPartners() ?: []);

        $result['mid'] = $member->getMother()?->getId();
        $result['fid'] = $member->getFather()?->getId();

        return $result;
    }
}
