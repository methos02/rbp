<?php include __DIR__.'/includes/init.php';
$factoryPiscine = Piscine::factory();

//Paramètre personnel
if ($log['droit'] < Droit::RESP) {
    $_SESSION['flash'] = Core_rbp::flash('danger', 'Accès interdit', 'Vous devez être connecté pour accéder à cette page');
    header('location:accueil.html');
    exit;
}

$piscines = $factoryPiscine -> getPiscines();
?>
<!DOCTYPE html>
<html>
    <?php include("includes/head.php"); ?>
    <body>
        <div class="container div-principale" >
            <?php include("includes/header.php"); ?>
            <div class="navbar navbar-default navbar-fixed-top navbar-secondaire">
                <div class="navbar-form navbar-right">
                    <a class="btn btn-default btn-primary" data-add="piscine" >Ajouter une pisicne </a>
                </div>
            </div>
            <div class="contenu">
                <h1> Les piscines </h1>
                <table id="table-piscine">
                    <tr>
                        <th> Nom </th>
                        <th> Ville </th>
                        <th></th>
                    </tr>
                    <?php foreach ($piscines as $piscine) : ?>
                        <tr>
                            <td data-nom><?= $piscine['pis_nom'] ?></td>
                            <td data-ville><?= $piscine['pis_ville'] ?></td>
                            <td><?= Core_rbp::generateBtnManage('piscine', $piscine['pis_id']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <?php include("includes/footer.php"); ?>
            <div class="modal fade" id="Modal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"></h4>
                            <div id="modal-message"></div>
                        </div>
                        <div class="modal-body">
                            <form name="form-piscine">
                                <div data-include="piscine_form"></div>
                                <button class="btn btn-primary" data-verif="form-piscine"> Envoyer </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include("includes/script.php"); ?>
    </body>
</html>
