<?php
if(!isset($noAjax)) {
    include_once (__DIR__.'/../includes/init.php');
    $piscineFactory = Piscine::factory();
    $Utils = Utils::factory();
    $result['message'] = "";
}

include ("verif/piscine_verif.php");

if($result['message'] == "" ) {
    $piscine = $piscineFactory->getPiscineByAdresse($_POST['numbRue_piscine'], $_POST['rue_piscine'], $_POST['cp_piscine'], $_POST['ville_piscine']);

    if(!empty($piscine) && $piscine['pis_supplogique'] == 0) {
        $result['message'] = Core_rbp::flash('danger', 'La piscine existe déjà.');
    }

    if ($result['message'] == "" && !empty($piscine)) {
        $piscineFactory->activatePiscine($piscine['pis_id']);
    }
}

if($result['message'] == "") {
    if($piscine == false) {
        $id_piscine = $piscineFactory->addPiscine($_POST['nom_piscine'], $_POST['numbRue_piscine'], $_POST['rue_piscine'], $_POST['cp_piscine'], $_POST['ville_piscine']);
    }

    $id_piscine = (isset($id_piscine))? $id_piscine : $piscine['pis_id'];

    if(!isset($noAjax)) {
        $_SESSION['flash'] = Core_rbp::flash('success', 'Piscine ajoutée.');
        $result['success'] = 1;
    }
}

if(!isset($noAjax)) {
    echo json_encode($result);
}