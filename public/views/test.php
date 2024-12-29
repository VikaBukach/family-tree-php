<?php

use FamilyTree\helpers\GenerateTreeHelper;

require_once __DIR__ . '/../../vendor/autoload.php';

GenerateTreeHelper::generate($_GET['id'] ?? 0);
$dataAsJson = json_encode(GenerateTreeHelper::getResult());

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
