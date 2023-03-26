<?php

use App\Core\Core_rbp;
use App\Core\Request;
use App\Models\News;

$meta['nom'] = 'Royal Brussels Poseidon - News';
$newsFactory = News::factory();
$form = Form::factoryForm();
$message = "";

if(isset($_GET['section']) && !isset(Section::SLUG_TO_ID[$_GET['section']])){
    $message = "La section est invalide.";
}

if($message =="" && isset($_GET['page']) && (!is_numeric($_GET['page']) || $_GET['page'] <= 0)){
    $message = "La page est invalide.";
}

$id_section = ($message == "" && isset($_GET['section']))? Section::SLUG_TO_ID[$_GET['section']] : null;

if($message == "" && isset($_GET['page'])) {
    $nb_news = $newsFactory->getNbNewsBySection($id_section);

    if($_GET['page'] > floor($nb_news / News::PER_PAGE) + 1) {
        $message = "La page est supérieur au nombre de news.";
    }
}

$page = ($message == "" && isset($_GET['page']) && is_numeric($_GET['page']))? $_GET['page'] : 1;

if($message != "") {
    $_SESSION['flash'] = Core_rbp::flash('danger', $message);
}

$section = (isset($_GET['section']))? $_GET['section'] : null;

$section_id = !is_null(Request::get('section_id')) ? ['section_id' => Request::get('section_id')] : [];
News::where(array_merge(['status' => News::S_VALIDE], $section_id))->limit(News::PER_PAGE)->get();

$news_count = News::where(array_merge(['status' => News::S_VALIDE], $section_id))->count();

ob_start();
?>
<div class="container reference">
    <div class="nav-news-secondaire">
        <h2 class="news-title">News</h2>
        <div class="news-pagination">
            <?php include_file(views_path('components/paginator.php'), ['count' => $news_count, 'per_page' => News::PER_PAGE]); ?>
        </div>
        <div class="btns-news-modif center-content">
            <?php if($log['droit'] >= Droit::RESP): ?>
                <a class="btn btn-default btn-primary btn-news-modif hidden-xs" href="/news_manage">Ajouter une news</a>
                <a class="btn btn-default btn-primary btn-news-modif visible-xs-inline-block" href="news_manage.html"><span class="glyphicon glyphicon-pencil"></span></a>
            <?php endif; ?>
        </div>
        <div class="center-content news-section reference form-inline">
            <?= $form->select('newsSection', 'Section souhaitée:', ['all' => 'Toutes'] + Section::SLUG_TO_NAME, ['verif' => 0, 'default' => $section])?>
        </div>
    </div>
    <?php if(!isset($_COOKIE['div_mail_news'])) { include('includes/form/mail_news_form.php');} ?>
    <div class="row" data-div="news">
        <?php
        foreach (News::where(array_merge(['status' => News::S_VALIDE], $section_id))->limit(News::PER_PAGE)->get() as $news) :
            include_file(views_path('pages/news/parts/_news-short.php'), compact('news'));
        endforeach;
        ?>
    </div>
    <div class="news-pagination">
        <?php include_file(views_path('components/paginator.php'), ['count' => $news_count, 'per_page' => News::PER_PAGE]); ?>
    </div>
    <?php if(isset($_COOKIE['div_mail_news'])) { include('includes/form/mail_news_form.php');} ?>
</div>
<div class="modal fade" id="Modal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-news" role="document">
        <div class="modal-content" data-affiche="news"></div>
    </div>
</div>

<?php
$content = ob_get_clean();

include views_path('layout\layout.php');