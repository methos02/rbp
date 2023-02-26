<?php
$form = Form::factoryForm();
?>
<li class="dropdown open" data-nav="gestion">
    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></a>
    <ul class="dropdown-menu" id="inscription" style="margin: 0; padding: 0">
        <li>
            <form name="mdp_modif" class="navbar-form navbar-left menu-inscription">
                <input type="hidden" value="<?php echo htmlspecialchars($_GET['cle']) ?>" name="cle" >
                <input type="hidden" value="<?php echo $_GET['id_user'] ?>" name="id_user" >
                <strong > Récupération mot de passe </strong>
                <div class="row-column">
                    <?= $form -> mdp('mdp_1', 'Mot de passe', ['obliger' => 1])?>
                    <?= $form -> mdp('mdp_2', 'Confirmation', ['obliger' => 1])?>
                    <input name="submit-mdp" type="submit" class="btn btn-default" data-verif="mdp_modif" value="Envoyer">
                </div>
            </form>
        </li>
        <li role="separator" class="divider"></li>
        <li class="margin-bot"><a href="" class="nav-link" data-ajax="connexion"> Connexion </a></li>
    </ul>
</li>