<?php include __DIR__ . '/../../includes/init.php';
$articleFactory = Article::factory();
$message = "";

if($log['droit'] < Droit::USER){
    $message = Core_rbp::flash('danger', "Vous n'avez pas le droit de modifier un article.");
}

if($message == "" && (!isset($_POST['id_article']) || !is_numeric($_POST['id_article']))) {
    $message = Core_rbp::flash('danger', "Vous n'avez pas le droit de modifier un article.");
}

if($message == "") {
    $article = $articleFactory->getArticle($_POST['id_article']);

    if(empty($article)) {
        $message = Core_rbp::flash('danger', "Aucun article ne correspond à l'id fournie.");
    }
}

if($message != "") {
    echo Core_rbp::flash("danger", $message);
    exit;
}
?>
<form  method="post" data-id_article="<?= $article['art_id'] ?>">
    <textarea name="modif_article_<?= $article['art_id'] ?>" id="modif" rows="10" cols="50" placeholder="Nouveau contenu"><?= $article['art_article'] ?></textarea>
    <br>
    <button type="submit" name="valide-modif" class="btn btn-default btn-sm" > Envoyer </button>
    <button type="submit" name="cancel-modif" class="btn btn-default btn-sm"> Annuler </button>
</form>