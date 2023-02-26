<?php include __DIR__ . '/../includes/init.php';
$piscineFactory = Piscine::factory();
$Utils = Utils::factory();
$Form = Form::factoryForm();
$result['message'] = "";

if(!isset($_POST['search']) || !$Utils -> checkNomEvent($_POST['search'])) {
    $result['message'] = "false_";
}

if($result['message'] == "") {
    $piscines = $piscineFactory -> recherchePiscine(rtrim($_POST['search']));

    if(empty($piscines)) {
        $result['message'] = "unfound_";
    }
}

if($result['message'] == "") {
    $arrayIdToName = $piscineFactory->arrayIdToName($piscines);
    $result['datalist'] = $Form->defineOptionDatalist($arrayIdToName, 'piscine');
}

echo json_encode($result);