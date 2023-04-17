<?php use App\Core\Form;

include __DIR__ . '/../includes/init.php';
$adherentFactory = Adherent::factory();
$Utils = Utils::factory();
$Form = Form::factoryForm();
$result['message'] = '';

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour modifier les droits d'un membre.");
}

if ($result['message'] == "" && ((!isset($_POST['search']) || !$Utils -> checkNom($_POST['search'])) && $_POST['search'] != "")) {
    $result['message'] = Core_rbp::flash('danger', "La recherche contient des caractères invalides.");
}

if($result['message'] == "") {
    $adherents = $adherentFactory->rechercheAdherents(rtrim($_POST['search']));
    $arrayIdToName = $adherentFactory->arrayIdToName($adherents);
    $result['datalist'] = $Form->defineOptionDatalist($arrayIdToName, 'adherent_name');
}

echo json_encode($result);
