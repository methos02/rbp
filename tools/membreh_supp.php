<?php include __DIR__ . '/../includes/init.php';
$clubFactory = Club::factory();
$result['message'] = "";

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour supprimer un membre d'honneur.");
}

if($result['message'] == "" && (!isset($_POST['id_membre']) || !is_numeric($_POST['id_membre']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id du membre d'honneur est invalide");
}

if($result['message']) {
    $membreh = $clubFactory->getMembreH($_POST['id_membre']);

    if(empty($membreh)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun membre d'honneur ne correspond à l'id");
    }
}

if ($result['message'] == "") {
    $supp = $clubFactory -> suppMembreH($_POST['id_membre']);

    $result['message'] = Core_rbp::flash('success',"Le membre d'honneur a bien été supprimé.");
    $result['id_membreh'] = $clubFactory -> getIdMembreHAlphabet();

    $membre_h = $clubFactory -> getMembreH($result['id_membreh']);
    $membre_h = $clubFactory -> setParams($membre_h);

    $result['fiche'] = Core_rbp::view('includes/fiche/membrehFiche', compact('membre_h', 'log'));
}

echo json_encode($result);