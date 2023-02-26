<?php
include __DIR__.'/../includes/init.php';
$newsFactory = News::factory();
$result['message'] = "";

if(!isset($_POST['id_news']) ||!is_numeric($_POST['id_news'])) {
    $result['message'] = Core_rbp::flash('danger', "L'id de la news est invalide.");
}

if ($result['message'] == "") {
    $news = $newsFactory->getNews($_POST['id_news']);

    if (empty($news))  {
        $result['message'] = Core_rbp::flash('danger', "La news est introuvable.");
    }
}

if ($result['message'] == "") {
    $news = $newsFactory->setParams($news);
    $result['news'] = Core_rbp::view('includes/fiche/newsFiche', compact('news'));
}

echo json_encode($result);