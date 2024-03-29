<?php
use App\Core\Auth;

?>
<li class="dropdown" data-nav="gestion">
    <a href="" class="dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
    <ul class="dropdown-menu">
        <?php if(Auth::is_admin()): ?>
            <li><a href=/membre>Droits d'accès</a></li>
            <li role="separator" class="divider"></li>
        <?php endif; ?>
        <li><a href="/adherent">Adhérents</a></li>
        <li><a href="/cotisation">Cotisation</a></li>
        <li role="separator" class="divider"></li>
        <li><a href="/piscines">Les piscines</a></li>
        <li><a href="/photo_manage/<?= Section::COMITE['slug'] ?>">Les photos</a></li>
        <li role="separator" class="divider"></li>
        <li>
            <form class="navbar-form" method="post" action="/t-deconnection">
                <button class="btn btn-default">Déconnecter</button>
            </form>
        </li>
    </ul>
</li>
