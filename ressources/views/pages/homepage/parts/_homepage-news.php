<?php
use App\Core\Core_rbp;
use App\Helpers\Auth;
use App\Models\News;
?>

<?php /** @var News $news */ ?>
<?php foreach (News::limit(2)->get() as $news) : ?>
    <div class="col-md-6">
        <div class="news-affiche reference margin-updown" style="background: url(<?= News::PATH_IMG_NEWS.$news->get('photo') ?>)" data-affiche_news="<?= $news->get('id_news') ?>">
            <div class="news-header">
                <img src="<?= images_url($news->getPictoPath()) ?>" class="img-circle img-thumbnail" alt="Picto de section">
                <div class="news-content">
                    <div class="news-titre"> <?= $news->get('titre') ?></div>
                    <div class="news-info">
                        <?= $news->get('date').' - '.$news->get('nom_posteur') ?>
                        <?= Auth::is_log() ? Core_rbp::generateBtnManage('news', $news->get('id_news'), '/news_manage/id_news-'. $news->get('id_news')): ''; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
