<?php

use App\Core\Form;
use App\Core\Request;
use App\Helpers\Html;

$form = Form::factoryForm();
?>
<li class="dropdown<?= Html::add_if('open', Request::contains('login')) ?>" data-nav="gestion">
    <a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
    <ul class="dropdown-menu menu-inscription" id="inscription">
        <li data-form="form_connexion">
            <ul>
                <li>
                    <form id="login_form" class="navbar-form navbar-left" method="post" action="/login" data-validate="login_form">
                        <h3> Connexion </h3>
                        <div class="row-column">
                            <?php Form::input_text('email', 'Adresse mail') ?>
                            <?php Form::password('password', 'Mot de passe') ?>
                        </div>
                        <button type="submit" class="btn btn-default">Connection</button>
                    </form>
                </li>
                <li role="separator" class="divider"></li>
                <li><a href="" class="nav-link" data-menu="form_mdp" >Mot de passe perdu</a></li>
                <li class="row-pad"><a class="nav-link" href="" data-menu="form_inscription" > Inscription </a></li>
            </ul>
        </li>
        <li data-form="form_inscription" style="display: none">
            <ul>
                <li>
                    <form name="inscription" class="navbar-form navbar-left">
                        <strong > Inscription </strong>
                        <div class="row-column">
                            <?= $form->mail('mail', 'Adresse mail', ['obliger' => 1])?>
                            <?= $form->mdp('mdp_1', 'Mot de passe', ['obliger' => 1])?>
                            <?= $form->mdp('mdp_2', 'Confirmation mot de passe', ['obliger' => 1])?>
                        </div>
                        <input name="submit" type="submit" class="btn btn-default" data-verif="inscription" value="Inscription">
                    </form>
                </li>
                <li role="separator" class="divider"></li>
                <li><a href="" class="nav-link" data-menu="form_validation2"> Ré-envoie mail validation</a></li>
                <li class="row-pad"><a href="" class="nav-link" data-menu="form_connexion" > Connexion </a></li>
            </ul>
        </li>
        <li data-form="form_mdp" style="display: none">
            <ul>
                <li>
                    <form name="mail_mdp" method="post" class="navbar-form navbar-left">
                        <strong > Récupération mot de passe </strong>
                        <div class="row-column">
                            <?= $form->mail('mail', 'Adresse mail', ['obliger' => 1])?>
                            <input type="submit" name="recup" class="btn btn-default" data-verif="mail_mdp" value="Envoie Mail">
                        </div>
                    </form>
                </li>
                <li role="separator" class="divider"></li>
                <li class="row-pad"><a class="nav-link" href="" data-menu="form_connexion" > Connexion </a></li>
            </ul>
        </li>
        <li data-form="form_validation2" style="display: none">
            <ul>
                <li>
                    <form name="mail_validation" method="post" class="navbar-form navbar-left">
                        <strong > Envoie mail validation </strong>
                        <div class="row-column">
                            <?= $form->mail('mail', 'Adresse mail', ['obliger' => 1])?>
                            <input type="submit" name="recup" class="btn btn-default" data-verif="mail_validation" value="Envoie Mail" >
                        </div>
                    </form>
                </li>
                <li role="separator" class="divider"></li>
                <li class="row-pad"><a class="nav-link" href="" data-menu="form_inscription" > Inscription </a></li>
            </ul>
        </li>
    </ul>
</li>
