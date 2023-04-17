<?php

use App\Core\Form;
use App\Core\Request;
use App\Helpers\Auth;
use App\Models\News;

if(!isset($news_count, $news_list, )) { echo 'Une des variables "news_count" ou "news_list" est inconnue.'; return; }

$meta['nom'] = 'Royal Brussels Poseidon - News';
$form = Form::factoryForm();

ob_start();
?>
    <div id="container_news_list" class="container reference">
        <div class="nav-news-secondaire">
            <h2 class="news-title">News</h2>
            <div class="news-pagination">
                <?php include_file(views_path('components/paginator'), ['count' => $news_count, 'per_page' => News::PER_PAGE]); ?>
            </div>
            <div class="btns-news-modif center-content">
                <?php if(Auth::is_log()): ?>
                    <a class="btn btn-default btn-primary btn-news-modif hidden-xs" href="/news_manage">Ajouter une news</a>
                    <a class="btn btn-default btn-primary btn-news-modif visible-xs-inline-block" href="news_manage.html"><span class="glyphicon glyphicon-pencil"></span></a>
                <?php endif; ?>
            </div>
            <div class="center-content news-section reference form-inline">
                <?= $form->select('section', 'Section souhaitée:', ['' => 'Toutes'] + Section::SLUG_TO_NAME, ['verif' => 0, 'default' => Request::get('section') ?? ''])?>
            </div>
        </div>
        <?php if(!isset($_COOKIE['div_mail_news'])) { include views_path('pages/newsletter/parts/newsletter_form.php');} ?>
        <div id="news_list" class="row" data-div="news">
            <?php include_file(views_path('pages/news/parts/_news-list'), compact('news_list')); ?>
        </div>
        <div class="news-pagination">
            <?php include_file(views_path('components/paginator'), ['count' => $news_count, 'per_page' => News::PER_PAGE]); ?>
        </div>
        <?php if(!isset($_COOKIE['div_mail_news'])) { include views_path('pages/newsletter/parts/newsletter_form.php');} ?>
    </div>
    <div id="news-modal" class="modal news-modal-container" data-modal="close" data-target="news-modal"></div>

<?php
$content = ob_get_clean();

include views_path('layout\layout.php');
