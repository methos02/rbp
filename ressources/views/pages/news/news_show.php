<?php
use  App\Models\News;
if(!isset($news)) { echo 'La variable news est inconnue'; return; }
?>
<div id="news-modal-content" class="modal-content news-modal-content" data-content>
    <button class="hide-element" data-modal="close" data-target="news-modal">X</button>
    <div class="modal-header">
        <div class="modal-title modal-news-titre reference" id="myModalLabel" style="background-image: url(<?= News::PATH_IMG_NEWS. $news->get('picture')  ?>);">
            <span><?= $news->get('title') ?></span>
        </div>
    </div>
    <div class="modal-body">
        <?= html_entity_decode($news->get('content')) ?>
    </div>
</div>
