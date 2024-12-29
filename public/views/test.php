<?php

use FamilyTree\entity\FamilyMember;
use FamilyTree\FamilyMemberHelper;

require_once __DIR__ . '/../../vendor/autoload.php';

$result = [];

function generateTree($result, $memberId)
{
    $member = FamilyMemberHelper::initMember($memberId);

    if (is_null($member)) {
        return $result;
    }

    $existingIds = array_column($result, 'id');
    if (!in_array($member->getId(), $existingIds)) {
        $result[] = prepareMember($member);
    }


    $partners = $member->getPartners();
    foreach ($partners as $partner){
        $existingIds = array_column($result, 'id');
        if (!in_array($partner->getId(), $existingIds)) {
            $result[] = prepareMember($partner);
//            $result[] = prepareMember($partner);
        }
    }

    $sisters = $member->getSisters();
    foreach ($sisters as $sister){
        $existingIds = array_column($result, 'id');
        if (!in_array($sister->getId(), $existingIds)) {
            $result[] = prepareMember($sister);
//            $result[] = generateTree($result, $sister->getId());
        }
    }

    $brothers = $member->getBrothers();
    foreach ($brothers as $brother){
        $existingIds = array_column($result, 'id');
        if (!in_array($brother->getId(), $existingIds)) {
            $result[] = prepareMember($brother);
        }
    }

    $father = $member->getFather();
    $existingIds = array_column($result, 'id');
    if ($father && !in_array($father->getId(), $existingIds)) {
        $result[] = prepareMember($father);
        if ($grandFather = $father->getFather()) {
            $result = generateTree($result, $grandFather->getId());
        }
    }

    $mother = $member->getMother();
    $existingIds = array_column($result, 'id');
    if ($mother && !in_array($mother->getId(), $existingIds)) {
        $result[] = prepareMember($mother);
        if ($grandMother = $father->getMother()) {
            $result = generateTree($result, $grandMother->getId());
        }
    }

    $daughters = $member->getDaughters();
    foreach ($daughters as $daughter){
        $existingIds = array_column($result, 'id');
        if (!in_array($daughter->getId(), $existingIds)) {
            $result[] = prepareMember($daughter);
        }
    }

    $sons = $member->getSons();
    foreach ($sons as $son){
        $existingIds = array_column($result, 'id');
        if (!in_array($son->getId(), $existingIds)) {
            $result[] = prepareMember($son);
        }
    }

    return $result;
}

function prepareMember(FamilyMember $member)
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

$result = generateTree($result, $_GET['id'] ?? 0);

$dataAsJson = json_encode($result);

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
