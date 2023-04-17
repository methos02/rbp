<?php use App\Core\Form;

include_once __DIR__.'/../init.php';
$piscineFactory = Piscine::factory();
$piscine = '';
$result['message'] = "";

$obliger = (strpos($_SERVER['PHP_SELF'],'piscines') !== false)? 1 : 0;

if(isset($_POST['id_piscine'])) {
    if (!is_numeric($_POST['id_piscine'])) {
        $result['message'] = 'id piscine invalide.';
    }

    if ($result['message'] == "") {
        $piscine = $piscineFactory->getPiscineByID($_POST['id_piscine']);

        if(empty($piscine)){
            $result['message'] = "Aucune piscine ne correspond à l'id renseignée.";
        }
    }
}

if($result['message'] != "") {
    echo Core_rbp::flash('danger', $result['message']);
    exit;
}

$formPiscine = Form::factoryForm($piscine);
?>
<?php if(is_array($piscine) && $result['message'] == "") { ?>
    <input type="hidden" name="id_piscine" value="<?php echo $piscine['pis_id']; ?>">
<?php } ?>
<div class="row-flex">
    <?= $formPiscine -> titre('nom_piscine', 'Nom de la piscine', ['width' => 'demi', 'obliger' => $obliger])?>
</div>
<div class="row-flex">
    <?= $formPiscine -> rue('rue_piscine', 'Nom de rue', ['width' => 'order', 'obliger' => $obliger])?>
    <?= $formPiscine -> numb_rue('numbRue_piscine', 'N° de rue', ['obliger' => $obliger])?>
</div>
<div class="row-flex">
    <?= $formPiscine -> cp('cp_piscine', 'Code postale', ['obliger' => $obliger])?>
    <?= $formPiscine -> ville('ville_piscine', 'Nom de la ville', ['width' => 'demi', 'obliger' => $obliger])?>
</div>
