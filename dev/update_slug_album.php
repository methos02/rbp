<?php
use App\Core\Connection;
use Ausi\SlugGenerator\SlugGenerator;

include __DIR__.'/../includes/init.php';
$bdd = Connection::getInstance();
$generator = new SlugGenerator();

$albums = $bdd->reqMulti('SELECT alb_id as id, alb_nom as nom, alb_slug as slug FROM t_album');

foreach($albums as $album) {
    $slug = $generator->generate($album['nom']);
    $bdd->req('UPDATE t_album SET alb_slug = :slug WHERE alb_id = :id', ['id' => $album['id'], 'slug' => $slug]);
}
