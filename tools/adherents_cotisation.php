<?php include __DIR__.'/../includes/init.php';
$adherentFactory = Adherent::factory();
$result['message'] = "";

if($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas l'autorisation de modifier les cotisations");
}

if($result['message'] == "") {
    foreach ($_POST as $id_adherent => $adherent){
        if($result['message'] == "" && !is_numeric($id_adherent)) {
            $result['message'] = Core_rbp::flash('danger', "L'un des id adhérent est invalide.");
        }

        if ($result['message'] == "" && !isset(Database::COT_ID_TO_LABEL[$adherent['id_cotisation']])) {
            $result['message'] = Core_rbp::flash('danger', "L'un des id cotisations est invalide.");
        }

        if ($result['message'] == "" && isset($adherent['montant']) && in_array($adherent['id_cotisation'], Database::ARRAY_NO_COT)) {
            $result['message'] = Core_rbp::flash('danger', "Vous avez introduit un montant de cotisation alors que l'utilisateur est dipensé.");
        }

        if ($result['message'] == "" && isset($adherent['montant']) && !is_numeric($adherent['montant']) && $adherent['montant'] != "") {
            $result['message'] = Core_rbp::flash('danger', "L'un des montants introduit n'est pas valide.");
        }

        if ($result['message'] == "" && isset($adherent['montant']) && $adherent['montant'] > Database::COT_ID_TO_NUMB[$adherent['id_cotisation']]) {
            $result['message'] = Core_rbp::flash('danger', "L'un des montants introduit est supérieur au montant à payer.");
        }
    }
}

if ($result['message'] == "") {
    $req_cotisation = $adherentFactory->updateAdherentsCotisation ($_POST);
    $result['message'] = Core_rbp::flash('success', "Les cotisations ont bien été modifiés.");
}

echo json_encode($result);