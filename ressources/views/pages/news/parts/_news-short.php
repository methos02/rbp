<?php
use App\Core\Core_rbp;
use App\Helpers\Auth;
use App\Models\News;

if(!isset($news)) { echo 'La variable news est inconnue'; return;}
?>
<div class="col-md-6">
    <div class="news-affiche reference margin-updown" style="background: url(<?= News::PATH_IMG_NEWS.$news->get('picture') ?>)" data-affiche_news="<?= $news->get('id') ?>">
        <div class="news-header">
            <img src="<?= images_url($news->getPictoPath()) ?>" class="img-circle img-thumbnail" alt="Picto de section">
            <div class="news-content">
                <div class="news-titre"> <?= $news->get('title') ?></div>
                <div class="news-info">
                    <?= $news->get('date').' - '.$news->get('created_by') ?>
                    <?= Auth::is_log() ? Core_rbp::generateBtnManage('news', $news->get('id'), '/news_manage/id_news-'. $news->get('id')): ''; ?>
                </div>
            </div>
        </div>
    </div>
</div>
