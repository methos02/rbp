<?php
use App\Core\Response;
use App\Models\News;

$newsFactory = News::factory();

if(!isset($_GET['news_id']) ||!is_numeric($_GET['news_id'])) return Response::json(['error' => "L'id de la news est invalide."], 400);

$news = News::find($_GET['news_id']);
if ($news == null) return Response::json(['error' => "La news est introuvable."], 404);

?>
<div class="modal-header">
    <div class="modal-title modal-news-titre reference" id="myModalLabel" style="background-image: url(<?= News::PATH_IMG_NEWS. $news->get('picture')  ?>);">
        <span><?= $news->get('title') ?></span>
    </div>
</div>
<div class="modal-body">
    <button type="button" class="close close-news" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <?= html_entity_decode($news->get('content')) ?>
</div>
