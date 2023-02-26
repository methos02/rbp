<form class="navbar-form navbar-left">
    <?php if($_SERVER['SCRIPT_NAME'] != "/adherent.php") : ?>
        <a class="btn btn-default btn-primary" href="/adherent"> Liste des adhérents </a>
    <?php endif; ?>
    <?php if($_SERVER['SCRIPT_NAME'] != "/adherent_manage.php") : ?>
        <a class="btn btn-default btn-primary" href="/adherent_manage">Ajouter membre</a>
    <?php endif; ?>
    <?php if($_SERVER['SCRIPT_NAME'] != "/preinscription.php") : ?>
        <a class="btn btn-default btn-primary" href="/preinscription">Préinscription</a>
    <?php endif; ?>
</form>