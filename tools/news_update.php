<?php use App\Models\News;

include __DIR__.'/../includes/init.php';
$newsFactory = News::factory();
$mailFactory = Mail::factory();
$Utils = Utils::factory();
$result['message'] = "";

if(!isset($_POST['id_news']) || !is_numeric($_POST['id_news'])){
    $result['message'] = Core_rbp::flash("danger","L'id de la news est incorrecte.");
}

if( $result['message'] == ""){
    include ('verif/news_verif.php');
}

if($result['message'] == ''){
    $news = $newsFactory->getNews($_POST['id_news']);

    if(empty($news)) {
        $result['message'] = Core_rbp::flash("danger","Aucune news ne correspond à l'id renseigné.");
    }
}

if($result['message'] == ''){
    if($_FILES['photo']['error'] != UPLOAD_ERR_NO_FILE) {
        $photoRemove = (!empty($news['photo']) && strpos($news['photo'], 'news_') === false)? $news['photo'] : "";
        $photoName = $newsFactory -> move_file('photo', News::PATH_IMG_REAL, $photoRemove);
    }

    $photo = isset($photoName) ? $photoName : $news['photo'];
    $update = $newsFactory->updateNews($_POST['titre'], $_POST['news'], $photo, $_POST['id_section'], $_POST['id_news']);

    $_SESSION['flash'] = Core_rbp::flash('success','La news a bien été modifié.');
}

echo json_encode($result);
