<?php include __DIR__.'/../includes/init.php';
$adherentFactory = Adherent::factory();
$result['message'] = "";

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droit pour accéder à cette page.");
}

if ($result['message'] == "" && (!isset($_POST['id_adherent']) || !is_numeric($_POST['id_adherent']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de l'adhérent est invalide.");
}

if ($result['message'] == "" && (!isset($_POST['id_saison']) || !is_numeric($_POST['id_saison']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de la saison est invalide.");
}

if($result['message'] == "") {
    $id_ads = $adherentFactory->getId_ads($_POST['id_adherent'], $_POST['id_saison']);

    if(empty($id_ads)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun adhérent ne correspond à l'id et la saison renseignée.");
    }
}

if($result['message'] == "") {
    $adherent = $adherentFactory->getAdherentSaison($id_ads);
    $adherent = $adherentFactory->setParams($adherent);
    $result['tableau'] = Core_rbp::view('includes/table/adherentsTable', ['adherents' => [$adherent], 'id_saison' => $_POST['id_saison'], 'saisonActive' => Saison::factory()->saisonActive(false)]);
}

echo json_encode($result);