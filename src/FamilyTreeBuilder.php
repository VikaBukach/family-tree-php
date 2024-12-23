<?php

namespace FamilyTree;

class FamilyTreeBuilder
{

    protected $result;

    public function __construct($result = null)
    {
        $this->result = $result;
    }

    public function buildTree($member_id = null, $visited = [])
    {
        if (in_array($member_id, $visited)) {
            return null;
        }

        $visited[] = $member_id;

        $db = new Db();
        $familyMember = $db->getMemberById($member_id); // Отримуємо інформацію про сімейного члена

        $relationships = $db->getFamilyRelationships($member_id); // Отримуємо звʼязки відносини для цього вузла
        $nodes = [];
//        var_dump($relationships);



        foreach($relationships as $relation) {
//            echo '<pre>' . print_r($relation, true) . '</pre>';
            $nodes [] = [
                'name' => $relation->related_name ?? 'Unknown',
                'img' => $relation->related_avatar ?? 'Unknown',
                'role_name' => $relation->role_name ?? 'Unknown', // роль члена
                'children' => $this->buildTree($relation->member_id, $visited) // Додатковий виклик buildTree для підвузлів
            ];
        }
        return $nodes;
    }

}