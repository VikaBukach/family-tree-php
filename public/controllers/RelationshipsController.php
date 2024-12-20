<?php



require_once '../../BaseController.php';



class RelationshipsController extends BaseController
{
    public function actionCreateRelation()
    {
        if($_POST) {


        }
    }

}

$controller = new RelationshipsController();
$controller->runAction($_GET['action'] ?? '');

