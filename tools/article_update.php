<?php
include __DIR__ . '/../includes/init.php';
$articleFactory = Article::factory();
$result['message'] = '';

if($log['droit'] < Droit::USER){
    $result['message'] = Core_rbp::flash('danger', "Vous devez être connecté pour modifier un article");
}

if($result['message'] == "" && (!isset($_POST['id_article']) || !is_numeric($_POST['id_article']))){
    $result['message'] = Core_rbp::flash('danger', "L'id de l'article est invalide.");
}

if($result['message'] == "" && (!isset($_POST['article']) || empty($_POST['article']))){
    $result['message'] = Core_rbp::flash('danger', "L'article est vide.");
}

if($result['message'] == ""){
    $article = $articleFactory->getArticle($_POST['id_article']);

    if(empty($article)) {
        $result['message'] = Core_rbp::flash('danger', "Aucun article ne correspond à l'id renseignée.");
    }
}

if($result['message'] == ""){
    $articleFactory->updateArticle(htmlspecialchars($_POST['article']), $_POST['id_article']);
    $result['message'] = Core_rbp::flash("success", "Article a été modifier");
    $result['success'] = 1;
}

echo json_encode($result);