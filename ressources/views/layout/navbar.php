<?php

use App\Core\Core_rbp;
use App\Core\Auth;

$flash = '';

if (isset($_GET['action']) && $_GET['action'] == 'new_mdp') {
    if(!isset($_GET['cle'])){
        $flash = Core_rbp::flash('danger','Absence de clé utilisateur.');
    }

    if($flash == '' && (!isset($_GET['id_user']) || !is_numeric($_GET['id_user']))) {
        $flash = Core_rbp::flash('danger','id utilisateur invalide.');
    }
}

?>
<header>
    <nav id="nav-header" class="navbar navbar-inverse navbar-fixed-top navbar-collapse">
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                <img src="/images/banniere_rbp_mini.jpg" alt="Brand" class="img-responsive">
            </a>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse navbar-right">
            <ul class="nav navbar-nav">
                <li data-nav="accueil"><a href="/">Accueil</a></li>
                <li data-nav="news"><a href="/news">News</a></li>
                <li class="dropdown" data-nav="club">
                    <a href="club.html" class="dropdown-toggle" data-toggle="dropdown"> Le Club <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="/club">Présentation</a></li>
                        <li><a href="/club#cotisation">Inscription</a></li>
                        <li><a href="/club#historique">Historique</a></li>
                        <li><a href="/club#photo">Photo</a></li>
                        <li><a href="/club#membre_h">Membre d'honneur</a></li>
                    </ul>
                </li>
                <li class="dropdown" data-nav="section">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="menu_section"> Section <span class="caret"></span></a>
                    <ul class="dropdown-menu" aria-labelledby="menu_section">
                        <li><a href="/natation">Natation</a></li>
                        <li><a href="/waterpolo">Water-polo</a></li>
                        <li><a href="/plongeon">Plongeon</a></li>
                    </ul>
                </li>
                <li data-nav="sponsor"><a href="/sponsor">Sponsors</a></li>
                <li data-nav="sponsor"><a href="/photo/comite">Photos</a></li>
                <li data-nav="contact"><a href="/contact">Nous contacter</a></li>
                <?php
                if(Auth::is_log()) {
                    include_file(views_path('layout/parts/admin_menu'));
                } elseif (isset($_GET['action']) && $_GET['action'] == 'new_mdp' && $flash == "") {
                    include_file(views_path('layout/parts/form_mdp_modif'));
                } else{
                    include_file(views_path('layout/parts/_login-form'));
                }
                ?>
            </ul>
        </div>
    </nav>
    <?php include_file(views_path('components/flash')) ?>
    <noscript><p class="alert">Veuillez activer le javascript de votre ordinateur pour que le site fonctionne correctement.</p></noscript>
</header>
