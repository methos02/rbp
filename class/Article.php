<?php
use Connection\Connection;
class Article extends Table {

    const S_ARTICLE = [
        Section::NATATION['id'] => ['presentation', 'groupe'],
        Section::WATERPOLO['id'] => ['presentation', 'adulte', 'jeune'],
        Section::PLONGEON['id'] => ['presentation', 'entrainement'],
        Section::COMITE['id'] => ['presentation', 'historique', 'cotisation', 'sponsor', 'pourquoi', 'comment']
    ];

    public static function factory() {
        $dbb = Connection::getInstance();
        $instance = new Article($dbb);

        return $instance;
    }

    public function getArticle($id_article) {
        return $this->bdd-> reqSingle('SELECT art_id, art_article, art_id_section, art_nom FROM t_article WHERE art_id = :id_article', array('id_article' => $id_article));
    }

    public function getArticlesBySection($id_section) {
        return $this->bdd-> reqMulti('SELECT art_id, art_nom, art_article FROM t_article WHERE art_id_section = :id_section', array('id_section' => $id_section));
    }

    public function updateArticle ($article, $id_article) {
        $this->bdd->req('UPDATE t_article SET art_article=:article, art_nom_modif = :nom_modif, art_date_modif=NOW() WHERE art_id = :id_article ', ['id_article' => $id_article, 'article' => $article,'nom_modif' => $_SESSION['auth']['user']]);
    }

    public function orderArticlesForSection($articles) {
        $articles_order = [];

        foreach ($articles as $article) {
            $articles_order[$article['art_nom']] = '<div data-id_article="'.$article['art_id'].'">'.html_entity_decode($article['art_article']).'</div>';
        }

        return $articles_order;
    }
}