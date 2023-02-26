<?php include __DIR__.'/../includes/init.php';
$sponsorFactory = Sponsor::factory();
$result['message'] = "";

if (!isset($_POST['id_section']) || (!is_numeric($_POST['id_section']) && $_POST['id_section'] != "all")) {
    $result['message'] = Core_rbp::flash('danger', "L'id de la section est invalide.");

}

if ($result['message'] == "" && $_POST['id_section'] != "all" && !isset(Section::ID_TO_NAME[$_POST['id_section']])) {
    $result['message'] = Core_rbp::flash('danger', "Aucune section ne correspond à l'id fournie.");
}

if($result['message'] == "" ){
    $sponsors = $sponsorFactory->getSponsorsBySection($_POST['id_section']);
    $result['sponsors'] = Core_rbp::view('includes/table/sponsorsTable', compact('sponsors', 'log'));
}

echo json_encode($result);