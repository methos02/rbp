<?php

use App\Core\Core_rbp;
use App\Models\News;

include __DIR__.'/../includes/init.php';
$newsFactory = News::factory();
$result['message'] = "";

if (!isset($_POST['sSection']) && (!isset(Section::SLUG_TO_ID[$_POST['sSection']]) && $_POST['sSection'] != 'all')) {
    $result['message'] = Core_rbp::flash('danger', "La section est invalide.");
}

if ($result['message'] == "" && isset($_POST['page']) && (!is_numeric($_POST['page']) || $_POST['page'] <= 0)) {
    $result['message'] = Core_rbp::flash('danger', "La page est invalide.");
}

if ($result['message'] == "") {
    $id_section = (isset($_POST['sSection']) && $_POST['sSection'] != 'all')? Section::SLUG_TO_ID[$_POST['sSection']] : null;
    $nb_news = $newsFactory->getNbNewsBySection($id_section);

    if(isset($_POST['page']) && $_POST['page'] > floor($nb_news / News::PER_PAGE) + 1) {
        $result['message'] = Core_rbp::flash('danger', "La page est supérieur au nombre de news.");
    }
}

if ($result['message'] == "") {
    $page = (isset($_POST['page']))? $_POST['page']: 1;
    $newsArray = $newsFactory->getNewsBySectionPage($id_section, $page);
    $newsArray = $newsFactory->setsParams($newsArray);

    $result['order_news'] = Core_rbp::view('includes/table/newsTable', compact('newsArray', 'log'));
    $result['paginateur'] = $newsFactory -> newsPaginateur($id_section, $page);
}

echo json_encode($result);
