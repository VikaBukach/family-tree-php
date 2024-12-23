<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use FamilyTree\Db;

use FamilyTree\structure\FamilyRelationshipsStructure;

//if (empty($_GET['id'])) {
//    header('Location: /');
//}

//$id = $_GET['id'];
$db = new Db();
///** @var FamilyRelationshipsStructure[] $relationships */

// Отримуємо відносини для конкретного члена родини:
//$relationships = $db->getFamilyRelationships($id);

// Отримуємо основну інформацію про члена родини:
$familyMember = $db->getMemberById(43);



$data = [
    ['id' => $familyMember['id'], 'pids' => [2], 'name' => $familyMember['name'], 'img' => $familyMember['avatar_path'], "gender" => $familyMember['sex'] === 0 ? "male" : "female"],
];

$dataAsJson = json_encode($data);




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

<script src="https://balkan.app/js/FamilyTree.js"></script>
<div id="tree"></div>


<script>
    var dataFromPhpAsJson = '<?= $dataAsJson ?>';
    console.log(dataFromPhpAsJson);


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
