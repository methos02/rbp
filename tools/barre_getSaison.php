<?php include __DIR__.'/../includes/init.php';
$adherentFactory = Adherent::factory();
$result['message'] = "";

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droit pour accéder à cette page.");
}

if ($result['message'] == "" && (!isset($_POST['id_saison']) || !is_numeric($_POST['id_saison']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de la saison est invalide.");
}

if ($result['message'] == "" && (!isset($_POST['id_section']) || (!isset(Section::ID_TO_NAME[$_POST['id_section']]) && $_POST['id_section'] != "all"))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de la section est invalide.");
}

if ($result['message'] == "" && (!isset($_POST['statut']) || !isset(Adherent::STATUT[$_POST['statut']]))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de la section est invalide.");
}

if($result['message'] == "") {
    $section = $adherentFactory->defineWhereSection($_POST['id_section']);
    $id_ads = $adherentFactory->getIdSaisonByParams($_POST['id_saison'], $section, Adherent::WHERE_STATUT[$_POST['statut']]);

    if(empty($id_ads)) {
        $result['tableau'] = Core_rbp::emptyResult('Aucun adhérent ne répond aux critères introduits.');
    }
}

if($result['message'] == "" && !empty($id_ads)) {
    $adherents = $adherentFactory->getAdherentSaison($id_ads, ['multi' => true]);
    $adherents = $adherentFactory->setsParams($adherents);
    $result['tableau'] = Core_rbp::view('includes/table/adherentsTable', ['adherents' => $adherents, 'id_saison' => $_POST['id_saison'], 'saisonActive' => Saison::factory()->saisonActive(false)]);
}

echo json_encode($result);