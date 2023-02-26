<?php include_once __DIR__.'/../includes/init.php';
$clubFactory = Club::factory();
$resultat['message'] = "";

if (!empty($_POST) && (!isset($_POST['id_membreh']) || !is_numeric($_POST['id_membreh']))) {
    $resultat['message'] = Core_rbp::flash('danger',"L'id du membre d'honneur est invalide.");
}

if ($resultat['message'] == "") {
    $membre_h = $clubFactory -> getMembreH($_POST['id_membreh']);

    if(empty($membre_h)) {
        $resultat['message'] = Core_rbp::flash('danger',"L'id fournit ne correspond à aucun membre.");
    }
}

if($resultat['message'] == "") {
    $membre_h = $clubFactory -> setParams($membre_h);
    $resultat['fiche'] = Core_rbp::view('includes/fiche/membrehFiche', compact('membre_h', 'log'));
}

echo json_encode($resultat);