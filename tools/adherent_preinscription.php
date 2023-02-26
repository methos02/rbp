<?php include __DIR__.'/../includes/init.php';
$adherentFactory = Adherent::factory();
$result['message'] = "";

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droit pour accéder à cette page.");
}

if ($result['message'] == "" && (!isset($_POST['id_adherent']) || !is_numeric($_POST['id_adherent']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de l'adhérent est invalide.");
}

if($result['message'] == "") {
    $adherent = $adherentFactory->getAdherent($_POST['id_adherent']);

    if(empty($adherent)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun adhérent ne correspond à l'id renseignée.");
    }
}

if($result['message'] == "") {
    $adherent = $adherentFactory->preInscrire($_POST['id_adherent']);
    $result['message'] = Core_rbp::flash('success', "L'adhérent a été réinscrit.");
    $result['success'] = 1;
}

echo json_encode($result);