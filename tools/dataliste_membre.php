<?php use App\Core\Form;

include __DIR__ . '/../includes/init.php';
$adherentFactory = Adherent::factory();
$Form = Form::factoryForm();
$Utils = Utils::factory();
$result['message'] = '';


if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour modifier les droits d'un membre.");
}

if ($result['message'] == "" && ((!isset($_POST['search']) || !$Utils -> checkNom($_POST['search'])) && $_POST['search'] != "")) {
    $result['message'] = Core_rbp::flash('danger', "La recherche contient des caractères invalides.");
}

if($result['message'] == "") {
    $membres = $adherentFactory->rechercheUsers(rtrim($_POST['search']));
    $arrayIdToName = $adherentFactory->arrayIdToName($membres);
    $result['datalist'] = $Form->defineOptionDatalist($arrayIdToName, 'membre');
}

echo json_encode($result);
