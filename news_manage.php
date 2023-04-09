<?php include __DIR__.'/includes/init.php';

if($log['droit'] == Droit::USER){
	$_SESSION['flash'] = Core_rbp::flash('danger','Vous devez être connecté pour accéder à cette page.');
	header('location:accueil.html');
	exit();
}

$newsFactory = News::factory();
$message = '';
$news = '';

if (isset($_GET['id_news']) && !is_numeric($_GET['id_news'])) {
    $message = Core_rbp::flash('danger',"L'id de la news est invalide.");
}

if( !isset($_SESSION['flash']) && isset($_GET['id_news'])) {
    $news = $newsFactory->getNews($_GET['id_news']);

    if(empty($news)) {
        $message = Core_rbp::flash('danger',"Aucune news ne correspond à l'id renseignée.");
    }

    if( $message == "" ) {
        $news['photo'] = News::PATH_IMG_NEWS . $news['photo'];
    }
}

if ($message != "") {
    $_SESSION['flash'] = $message;
    header('location:/news');
    exit();
}

$formNews = Form::factoryForm($news);
$id_section = (isset($news['id_section']))? $news['id_section']: null;
?>
<!DOCTYPE html>
<html>
	<?php include("includes/head.php"); ?>
	<body class="no-sectionBarre">
		<?php include("includes/header.php"); ?>
		<div class="contenu container">
            <h4 class="bg-primary h4-size row-pad"><?= (isset($_GET['id_news'])?'Modification ': 'Nouvelle ') ?> News</h4>
            <form name="form-news" method="post" action="news_<?= (isset($_GET['id_news']))? 'update': 'add'; ?>">
                <?= (isset($_GET['id_news'])? '<input type="hidden" name="id_news" value="'.$news['news_id'].'">': '') ?>
                <div class="row-flex">
                    <?= $formNews->select('id_section', 'Section :', Section::ID_TO_NAME, ['obliger' => 1, 'default' => $id_section, 'null' => true]) ?>
                    <?= $formNews->titre('titre', 'Titre', ['obliger' => 1, 'width' => 'order'])?>
                </div>
                <div class="row-flex">
                    <?= $formNews->text('news', 'Composer votre news.', ['obliger' => 1, 'width' => 'order'])?>
                    <?= $formNews->fileImg('photo', 'Choisissez une image', ['option' => 'photo'])?>
                </div>
                <button class="btn btn-primary" data-verif="form-news">
                    <span class="btn-content"> Publier </span>
                    <img src="/img/loader.gif" alt="loader" class="btn-loader" style="display: none">
                </button>
            </form>
		</div>
		<?php include("includes/footer.php"); ?>
		<?php include("includes/script.php"); ?>
		<script type="text/javascript" > CKEDITOR.replace('news'); </script>
	</body>
</html>	