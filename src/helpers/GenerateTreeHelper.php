<?php

namespace FamilyTree\helpers;

use FamilyTree\entities\FamilyMember;

class GenerateTreeHelper
{
    private const DEPTH_VALUE = 4;

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

    private static function generate(?FamilyMember $ownMember)
    {
        if (is_null($ownMember)) {
            return self::$membersForTree;
        }

        self::$membersForTree[self::$currentCircle][] = $ownMember;

        $members = $ownMember->getPartners();
        foreach ($members as $member) {
            self::$membersForTree[self::$currentCircle][] = $member;
        }

        $members = $ownMember->getParents();
        foreach ($members as $member) {
            self::$membersForTree[self::$currentCircle][] = $member;
        }

        $members = $ownMember->getChildren();
        foreach ($members as $member) {
            self::$membersForTree[self::$currentCircle][] = $member;
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

        $members = $member->getParents();
        /** @var FamilyMember $item */
        foreach ($members as $item) {
            if ($item?->getSex() === 'female') {
                $result['mid'] = $item?->getId();
            } else {
                $result['fid'] = $item?->getId();
            }
        }

        return $result;
    }
}
