<?php
use App\Core\Core_rbp;
use App\Core\Request;
use App\Core\Response;
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

$page = ($message == "" && isset($_GET['page']) && is_numeric($_GET['page']))? $_GET['page'] : 1;

if($message != "") {
    $_SESSION['flash'] = Core_rbp::flash('danger', $message);
}

$section = (isset($_GET['section']))? $_GET['section'] : null;

$section_condition = !is_null(Request::get('section')) ? ['section_id' => Section::get('id', Request::get('section'))] : [];

$news_list = News::where(array_merge(['status' => News::S_VALIDE], $section_condition))->paginate(News::PER_PAGE);
$news_count = News::where(array_merge(['status' => News::S_VALIDE], $section_condition))->count();

if(Request::isAjax()) {
    return Response::json([
        'news_list' => views_render('pages/news/parts/_news-list', compact('news_list')),
        'paginator' => views_render('components/paginator', ['count' => $news_count, 'per_page' => News::PER_PAGE])
    ]);
}

ob_start();
?>
    <div id="container_news_list" class="container reference">
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
                <?= $form->select('section', 'Section souhaitée:', ['all' => 'Toutes'] + Section::SLUG_TO_NAME, ['verif' => 0, 'default' => $section])?>
            </div>
        </div>
        <?php if(!isset($_COOKIE['div_mail_news'])) { include('includes/form/mail_news_form.php');} ?>
        <div id="news_list" class="row" data-div="news">
            <?php include_file(views_path('pages/news/parts/_news-list.php'), compact('news_list')); ?>
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
