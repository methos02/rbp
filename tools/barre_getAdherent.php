<?php include __DIR__.'/../includes/init.php';
$adherentFactory = Adherent::factory();
$form = Form::factoryForm();
$result['message'] = "";

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droit pour accéder à cette page.");
}

if ($result['message'] == "" && (!isset($_POST['id_adherent']) || !is_numeric($_POST['id_adherent']))) {
    $result['message'] = Core_rbp::flash('danger', "L'id de l'adhérent est invalide.");
}

if($result['message'] == "") {
    $saisons = $adherentFactory->getSaisonsFromAdherent($_POST['id_adherent']);

    if(empty($saisons)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun adhérent ne correspond à l'id renseignée.");
    }
}

if($result['message'] == "") {
    $idCurentSaison = key($saisons);
    $id_ads = $adherentFactory->getId_ads($_POST['id_adherent'], $idCurentSaison);
    $adherent = $adherentFactory->getAdherentSaison($id_ads);
    $adherent = $adherentFactory->setParams($adherent);
    $result['tableau'] = Core_rbp::view('includes/table/adherentsTable', ['adherents' => [$adherent], 'id_saison' => $idCurentSaison, 'saisonActive' => Saison::factory()->saisonActive(false)]);
    $result['options'] = $form->defineOptions($saisons, ['default' => $idCurentSaison]);
}

echo json_encode($result);