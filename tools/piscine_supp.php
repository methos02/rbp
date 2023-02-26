<?php include __DIR__ . '/../includes/init.php';
$piscineFactory = Piscine::factory();
$result['message'] = "";

if ($log['droit'] < Droit::RESP) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas les droits pour modifier les droits d'un membre.");
}

if ($result['message'] == "" && (!isset($_POST['id_piscine']) || !is_numeric($_POST['id_piscine']))) {
    $result['message'] = Core_rbp::flash('danger', 'ID piscine invalide.');
}

if ($result['message'] == "") {
    $piscine = $piscineFactory -> getPiscineByID($_POST['id_piscine']);

    if (empty($piscine)) {
        $result['message'] = Core_rbp::flash('danger', "Aucune piscine ne correspond à l'id introduite.");
    }
}
if ($result['message'] == "") {
    $piscineFactory->suppPiscine($_POST['id_piscine']);

    $result['message'] = Core_rbp::flash('success','Piscine supprimée.');
    $result['success'] = 1;
}

echo json_encode($result);