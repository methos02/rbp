<?php

use App\Core\Core_rbp;
use App\Helpers\Auth;

$newsFactory = News::factory();
$newsArray = $newsFactory->getNewsAccueil();
?>
<?php foreach ($newsArray as $news) : ?>
    <div class="col-md-6">
        <div class="news-affiche reference margin-updown" style="background: url(<?= News::PATH_IMG_NEWS.$news['photo'] ?>)" data-affiche_news="<?= $news['id_news']?>">
            <div class="news-header">
                <img src="/images/picto_<?= $news['id_section'] ?>.png" class="img-circle img-thumbnail" alt="Picto de section">
                <div class="news-content">
                    <div class="news-titre"> <?= $news['titre'] ?></div>
                    <div class="news-info">
                        <?= $news['date'].' - '.$news['nom_posteur'] ?>
                        <?= Auth::is_log() ? Core_rbp::generateBtnManage('news', $news['id_news'], '/news_manage/id_news-'. $news['id_news']): ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
