<?php include_once (__DIR__.'/../includes/init.php');
$result['message'] = "";
$http_referer = $_SERVER['HTTP_REFERER'];
$piscineFactory = Piscine::factory();
$Utils = Utils::factory();

include ("verif/piscine_verif.php");

if ($result['message'] == "" && (!isset($_POST['id_piscine']) || !is_numeric($_POST['id_piscine']))){
    $result['message'] = Core_rbp::flash('danger',"L'id piscine est incorrecte.");
}

if($result['message'] == "") {
    $piscine = $piscineFactory->getPiscineByID($_POST['id_piscine']);

    if (empty($piscine)) {
        $result['message'] = Core_rbp::flash('danger', 'ID piscine introuvable.');
    }
}

if($result['message'] == "") {
    $piscineFactory->updatePiscine($_POST['nom_piscine'], $_POST['numbRue_piscine'], $_POST['rue_piscine'], $_POST['cp_piscine'], $_POST['ville_piscine'], $_POST['id_piscine']);
    $_SESSION['flash'] = Core_rbp::flash('success', 'Piscine modifiée');
    $result['success'] = 1;
}

if(strpos( $http_referer,'piscine') !== false) {
    echo json_encode($result);
}