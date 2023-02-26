<?php
include __DIR__ . '/../includes/init.php';
$articleFactory = Article::factory();
$result['message'] = '';

if($log['droit'] < Droit::USER){
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas le droit de modifier un article.");
}

if($result['message'] == "" && (!isset($_POST['id_article']) || !is_numeric($_POST['id_article']))) {
    $result['message'] = Core_rbp::flash('danger', "Vous n'avez pas le droit de modifier un article.");
}

if($result['message'] == "") {
    $article = $articleFactory->getArticle($_POST['id_article']);

    if(empty($article)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun article ne correspond à l'id fournie.");
    }
}

if($result['message'] == ""){
    $result['article'] = html_entity_decode($article['art_article']);
}

echo json_encode($result);