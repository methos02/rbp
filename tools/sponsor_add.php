<?php include __DIR__.'/../includes/init.php';
$Utils = Utils::factory();
$sponsorFactory = Sponsor::factory();
$result['message'] = "";

include ('verif/sponsor_verif.php');

if ($result['message'] == '') {
    $sponsor = $sponsorFactory->getSponsorByname($_POST['nom']);

    if(!empty($sponsor) && $sponsor['spo_supplogiq'] == 0) {
        $result['message'] = Core_rbp::flash("danger","Le sponsor existe déjà.");
    }

    if (!empty($sponsor)) {
        $nom_logo = $sponsorFactory -> move_file('logo', Sponsor::URL_REAL_PATH, $sponsor['spo_logo']);
        $sponsorFactory->updateSponsorByName($_POST['nom'], $_POST['id_section'], $_POST['numbRue_sponsor'], $_POST['rue_sponsor'], $_POST['cp_sponsor'], $_POST['ville_sponsor'], $_POST['tel'], $_POST['mail'], $_POST['site'], $_POST['description'], $nom_logo, $_POST['id_domaine']);
    }
}

if ($result['message'] == '') {
    if (empty($sponsor)) {
        $nom_logo = $sponsorFactory -> move_file('logo', Sponsor::URL_REAL_PATH);
        $id_sponsor = $sponsorFactory->addSponsor($_POST['nom'], $_POST['id_section'], $_POST['numbRue_sponsor'], $_POST['rue_sponsor'], $_POST['cp_sponsor'], $_POST['ville_sponsor'], $_POST['tel'], $_POST['mail'], $_POST['site'], $_POST['description'], $nom_logo,  $_POST['id_domaine']);
    }

    $id_sponsor = ($id_sponsor)? $id_sponsor : $sponsor ;
    $_SESSION['flash'] = Core_rbp::flash('success','Le sponsor a bien été ajouté.');
    $result['url'] = '/sponsor_manage/id_sponsor-'. $id_sponsor;
}

echo json_encode($result);