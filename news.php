<?php

use App\Models\News;

include __DIR__.'/includes/init.php';
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

    if($_GET['page'] > floor($nb_news / News::NUMBER_NEWS) + 1) {
        $message = "La page est supérieur au nombre de news.";
    }
}

$page = ($message == "" && isset($_GET['page']) && is_numeric($_GET['page']))? $_GET['page'] : 1;

if($message != "") {
    $_SESSION['flash'] = Core_rbp::flash('danger', $message);
}

$section = (isset($_GET['section']))?$_GET['section'] : null;

$paginateur = $newsFactory -> newsPaginateur($id_section, $page);
$newsArray = $newsFactory->getNewsBySectionPage($id_section, $page);
$newsArray = $newsFactory->setsParams($newsArray);
?>
<!DOCTYPE html>
<html>
	<?php include("includes/head.php"); ?>
	<body class="no-sectionBarre">
        <?php include("includes/header.php"); ?>
        <div class="container reference">
            <div class="nav-news-secondaire">
                <h2 class="news-title">News</h2>
                <div class="news-pagination"> <?php echo $paginateur ?> </div>
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
            <div class="row" data-div="news"><?php include ('includes/table/newsTable.php') ?></div>
            <div class="news-pagination"> <?php echo $paginateur ?> </div>
            <?php if(isset($_COOKIE['div_mail_news'])) { include('includes/form/mail_news_form.php');} ?>
        </div>
        <div class="modal fade" id="Modal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-news" role="document">
                <div class="modal-content" data-affiche="news"></div>
            </div>
        </div>
        <?php include("includes/footer.php"); ?>
        <?php include("includes/script.php"); ?>
        <script src='https://www.google.com/recaptcha/api.js'></script>
	</body>
</html>	
