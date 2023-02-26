<?php include __DIR__.'/../includes/init.php';
$adherentFactory = Adherent::factory();
$result['message'] = '';

if (!isset($_POST['id_ads']) || !is_numeric($_POST['id_ads'])) {
    $result['message'] = Core_rbp::flash('danger', "L'id de l'adhérent est invalide.");
}

if ($result['message'] == "") {
    $adherent = $adherentFactory->getAdherentSaison($_POST['id_ads']);

    if(empty($adherent)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun adhérent ne correspond à l'id renseignée.");
    }

    if($result['message'] == "") {
        $adherent['categories'] = $adherentFactory->orderCategories($adherentFactory->getAdherentCategories($_POST['id_ads']));
        $adherent['cs'] = $adherentFactory->getAdherentCs($_POST['id_ads']);
        $adherent = $adherentFactory->setParams($adherent);

        $result['adherent'] = Core_rbp::view('includes/fiche/adherentFiche', ['adherent' => $adherent]);
    }
}

echo json_encode($result);