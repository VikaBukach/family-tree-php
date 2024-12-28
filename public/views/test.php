<?php

use FamilyTree\entity\FamilyMember;
use FamilyTree\FamilyMemberHelper;

require_once __DIR__ . '/../../vendor/autoload.php';

/*
$member = FamilyMemberHelper::initMember(35);

$partner = $member->getPartners();

$mama = $member->getMother();
$fath = $member->getFather();

$daugh = $member->getDaughter();
$son = $member->getSon();

$grandMother1 = $mama->getMother();

*/

//$data = [
//    ['id' => $familyMember['id'], 'pids' => [2], 'name' => $familyMember['name'], 'img' => $familyMember['avatar_path'], "gender" => $familyMember['sex'] === 0 ? "male" : "female"],
//];

function generateTree($memberId, $depth = 3)
{
    $member = FamilyMemberHelper::initMember($memberId);

    $partners = $member->getPartners();
    $sisters = $member->getSisters();
    $brothers = $member->getBrothers();
    $father = $member->getFather();
    $mother = $member->getMother();
    $daughters = $member->getDaughters();
    $sons = $member->getSons();





$dataAsJson = json_encode([]);




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
