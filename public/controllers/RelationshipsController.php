<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use FamilyTree\BaseController;

class RelationshipsController extends BaseController
{
    public function actionCreateRelation()
    {
        if($_POST) {
           $member_id = $_POST['member_id'] ?? '';
           $related_member_id = $_POST['related_member_id'] ?? '';
           $relationship_type = $_POST['relationship_type'] ?? '';

           $this->db->createReletionship($member_id, $related_member_id, $relationship_type);
        }
    }

}

$controller = new RelationshipsController();
$controller->runAction($_GET['action'] ?? '');

