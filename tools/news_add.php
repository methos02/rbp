<?php use App\Models\News;

include __DIR__.'/../includes/init.php';
$newsFactory = News::factory();
$mailFactory = Mail::factory();
$Utils = Utils::factory();
$result['message'] = "";

include ('verif/news_verif.php');

/*Enregistrement de la news*/
if($result['message'] == ''){
    $photoName = $newsFactory->move_file('photo', News::PATH_IMG_REAL);
    $photoName = ($photoName != null)? $photoName :'news_'.$_POST['id_section'].".jpg";

    $newsFactory->addNews($_POST['titre'], $_POST['news'], $photoName, $_POST['id_section'], $_SESSION['auth']['user']);
    $result['statut'] = $mailFactory->sendMailNews($_POST['titre']);
    $_SESSION['flash'] = Core_rbp::flash('success','La news a bien été créé.');
}

echo json_encode($result);
