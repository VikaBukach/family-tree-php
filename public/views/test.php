<?php

use FamilyTree\helpers\FamilyMemberHelper;
use FamilyTree\helpers\GenerateTreeHelper;

require_once __DIR__ . '/../../vendor/autoload.php';

session_start();
if (empty($_SESSION['user_id']) || $_SESSION['user_id'] !== 35) {
    header('Location: /views/auth.php');
}
$member = FamilyMemberHelper::initMember($_GET['id'] ?? 35);
GenerateTreeHelper::generateStart($member);
$membersForTree = GenerateTreeHelper::getMembersForTree();


//$membersForTree = [
//    [
//        'id' => 35,
//        'title' => 'Вікторія Букач',
//        'img' => '/../img/677111ac63fb3-дівч2.jpg',
//        'gender' => 'female',
//        'mid' => 39,
//        'fid' => 20,
//    ],
//    [
//        'id' => 39,
//        'title' => 'Маргарита Колеснікова',
//        'img' => '/../img/676ff3bb8e5e6-gir1.jpg',
//        'gender' => 'female',
//        'mid' => 40,
//        'fid' => 49,
//    ],
//    [
//        'id' => 20,
//        'title' => 'Маргарит1 Колеснікова',
//        'img' => '/../img/676ff3bb8e5e6-gir1.jpg',
//        'gender' => 'female',
////        'mid' => 40,
////        'fid' => 49,
//    ],
//    [
//        'id' => 49,
//        'title' => 'Михайло Тітов',
//        'img' => '/../img/676ff5591594b-ded1.jpg',
//        'gender' => 'male',
//        'mid' => NULL,
//        'fid' => NULL,
//    ],
//    [
//        'id' => 40,
//        'title' => 'Надія тітова',
//        'img' => '/../img/676ff4418d275-ba6.jpg',
//        'gender' => 'female',
//        'mid' => NULL,
//        'fid' => NULL,
//    ]
//];

$dataAsJson = json_encode($membersForTree);


$dataAsJson = json_encode($membersForTree);

?>
<style>
    html, body {
        margin: 0px;
        padding: 0px;
        width: 100%;
        height: 100%;
        font-family: Helvetica;
        overflow: hidden;
    }

    #tree {
        width: 100%;
        height: 100%;
    }
</style>

<script src="/js/FamilyTree.js"></script>
<div id="tree"></div>


<script>
    var dataFromPhpAsJson = '<?= $dataAsJson ?>';

    //JavaScript
    var options = getOptions();

    var chart = new FamilyTree(document.getElementById("tree"), {
        mouseScrool: FamilyTree.none,
        scaleInitial: options.scaleInitial,
        siblingSeparation: 120,
        template: 'john',
        nodeBinding: {
            field_0: "name", //name
            field_1: "title", //role
            img_0: "img", //avatar
        }
    });


    chart.load(JSON.parse(dataFromPhpAsJson));

    function getOptions() {
        const searchParams = new URLSearchParams(window.location.search);
        var fit = searchParams.get('fit');
        var enableSearch = true;
        var scaleInitial = 1;
        if (fit == 'yes') {
            enableSearch = false;
            scaleInitial = FamilyTree.match.boundary;
        }
        return {enableSearch, scaleInitial};
    }

</script>
