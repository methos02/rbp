<?php
use  App\Models\News;
if(!isset($news)) { echo 'La variable news est inconnue'; return; }
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
