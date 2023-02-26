<?php include __DIR__.'/../includes/init.php';
$Utils = Utils::factory();
$sponsorFactory = Sponsor::factory();
$result['message'] = "";

include ('verif/sponsor_verif.php');

if ($result['message'] == '' && (!isset($_POST['id_sponsor']) || !is_numeric($_POST['id_sponsor']))) {
    $result['message'] = Core_rbp::flash("danger","L'id du sponsor est invalide.");
}

if ($result['message'] == '') {
    $sponsor = $sponsorFactory -> getSponsor($_POST['id_sponsor']);

    if (empty($sponsor)) {
        $result['message'] = Core_rbp::flashHTML("danger","Aucun sponsor ne correspond à l'id renseigné.");
    }

    if ($result['message'] == "" && $sponsor['spo_supplogiq'] == 1) {
        $result['message'] = Core_rbp::flashHTML("danger","Ce sponsor a été supprimé.");
    }
}

if ($result['message'] == '') {
    $nom_logo = $sponsorFactory -> move_file('logo', Sponsor::URL_REAL_PATH, $sponsor['logo']);
    $sponsorFactory->updateSponsor($_POST['id_sponsor'], $_POST['nom'], $_POST['id_section'], $_POST['numbRue_sponsor'], $_POST['rue_sponsor'], $_POST['cp_sponsor'], $_POST['ville_sponsor'], $_POST['tel'], $_POST['mail'], $_POST['site'], $_POST['description'], $nom_logo, $_POST['id_domaine']);
    $result['message'] = Core_rbp::flash('success','Le sponsor a bien été modifié.');
}

echo json_encode($result);