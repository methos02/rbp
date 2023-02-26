<?php include __DIR__ . '/../includes/init.php';
$sponsorFactory = Sponsor::factory();
$resultat['message'] = "";

if (!isset($_POST['id_sponsor']) || !is_numeric($_POST['id_sponsor'])) {
    $resultat['message'] = Core_rbp::flash("danger","L'id du sponsor est invalide.");
}

if ($resultat['message'] == "") {
    $sponsor = $sponsorFactory -> getSponsor($_POST['id_sponsor']);

    if(empty ($sponsor)) {
        $resultat['message'] = Core_rbp::flash("danger","Aucun sponsor ne correspond à l'id fournie.");
    }
}

if ($resultat['message'] == "") {
    $resultat['fiche'] = Core_rbp::view('includes/fiche/sponsorFiche', compact('sponsor'));
}

echo json_encode($resultat);