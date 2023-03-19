<?php

namespace App\Models;

use Section;

class News extends Model {
    protected static string $table = "news";

    protected string $title;
    protected string $content;
    protected string $picture;
    protected string $created_by;
    protected string $created_at;
    protected int $section_id;

    const PATH_IMG_REAL = '/images/news/';
    const PATH_IMG_NEWS = '/news/';
    const EXT_NEWS = ['jpeg', 'jpg'];
    const SIZE_NEWS = '40048000';
    const CLE_CRON = 'GnQzGnYObqjvsNU6dMEM';
    const IMG_DEFAULT_COMITE = 'news_' . Section::COMITE['id'] . '.jpg';
    const IMG_DEFAULT_NAT = 'news_' . Section::NATATION['id'] . '.jpg';
    const IMG_DEFAULT_WP = 'news_' . Section::WATERPOLO['id'] . '.jpg';
    const IMG_DEFAULT_PLO = 'news_' . Section::PLONGEON['id'] . '.jpg';

    const MAIL_ACTIF = 0;
    const MAIL_SUPP = 1;

    const NUMBER_NEWS = 6;

    public function getPictoPath():string {
        return "picto_$this->section_id.png";
    }

    public function addNews($titre, $news, $photo, $id_section, $posteur)
    {
        $this->bdd->req('INSERT INTO t_news (news_titre, news_news, news_photo, news_nom_posteur, news_date_p, news_ID_section) VALUES (:titre, :news, :photo, :nom_posteur, NOW(), :id_section)', array('titre' => $titre, 'news' => $news, 'photo' => $photo, 'nom_posteur' => $posteur, 'id_section' => $id_section));
        return $this->bdd->last();
    }

    public function updateNews($titre, $news, $photo, $id_section, $id_news)
    {
        $update = $this->bdd->req('UPDATE t_news SET news_titre = :titre, news_news = :news, news_photo = :photo, news_ID_section = :id_section, news_nom_modif = :nom_posteur, news_date_modif = NOW() WHERE news_ID = :id_news',
            array('id_news' => $id_news, 'titre' => $titre, 'news' => htmlspecialchars($news), 'photo' => $photo, 'nom_posteur' => $_SESSION['auth']['user'], 'id_section' => $id_section));
        return $update->rowCount();
    }

    public function suppNews($id_news)
    {
        $supp = $this->bdd->req('UPDATE t_news SET news_supplogiq = 1, news_nom_modif = :nom_modif, news_date_modif = NOW() WHERE news_ID = :id_news', ['nom_modif' => $_SESSION['auth']['user'], 'id_news' => $id_news]);
        return $supp->rowCount();
    }

    public function getNews($id_news)
    {
        return $this->bdd->reqSingle('SELECT news_id, news_titre as titre, news_news as news, news_photo as photo, news_ID, news_ID_section as id_section FROM t_news WHERE news_ID =:id_news', ['id_news' => $id_news]);
    }

    public function getNbNewsBySection($id_section)
    {
        $id_section = ($id_section == null || !in_array($id_section, [1, 2, 3, 4])) ? '1,2,3,4' : $id_section;

        $nb_news = $this->bdd->reqSingle('SELECT count(*) as number FROM t_news WHERE news_ID_section IN (' . $id_section . ') AND news_supplogiq = 0');
        return $nb_news['number'];
    }

    public function getNewsAccueil()
    {
        return $this->bdd->reqMulti('SELECT news_ID as id_news, news_nom_posteur as nom_posteur, DATE_FORMAT(news_date_p, \'%d/%m/%Y\') AS date, news_titre as titre, news_news as news, news_photo as photo, news_ID_section as id_section FROM t_news WHERE news_ID_section IN (1,2,3,4) AND news_supplogiq = 0 ORDER BY news_date_p DESC LIMIT 0,2');
    }

    public function getNewsBySectionPage($id_section, $page)
    {
        $id_section = ($id_section == null || !in_array($id_section, [1, 2, 3, 4])) ? '1,2,3,4' : $id_section;
        $limite = ($page == null) ? 0 : ($page - 1) * News::NUMBER_NEWS;

        return $this->bdd->reqMulti('SELECT news_ID as id_news, news_nom_posteur as nom_posteur, DATE_FORMAT(news_date_p, \'%d/%m/%Y\') AS date, news_titre as titre, news_news as news, news_photo as photo, news_ID_section as id_section FROM t_news WHERE news_ID_section IN (' . $id_section . ') AND news_supplogiq = 0 ORDER BY news_date_p DESC LIMIT ' . $limite . ',6');
    }

    public function setParams(array $news): array
    {
        $news['photo'] = (file_exists(__DIR__ . '/..' . News::PATH_IMG_REAL . $news['photo'])) ? $news['photo'] : 'news_' . $news['id_section'] . '.jpg';
        return $news;
    }

    public function setsParams(array $newsArray): array
    {
        foreach ($newsArray as $key => $news) {
            $newsArray[$key] = $this->setParams($news);
        }

        return $newsArray;
    }

    public function newsPaginateur($id_section, $page)
    {
        $nb_news = $this->getNbNewsBySection($id_section);

        if ($nb_news == '0') {
            return '';
        }

        $page_max = floor($nb_news / News::NUMBER_NEWS) + 1;
        $page_under = ($page > 1) ? ' data-page="' . ($page - 1) . '"' : '';
        $page_up = ($page < $page_max) ? ' data-page="' . ($page + 1) . '"' : '';

        $prevent_under = ($page == 1) ? ' link-prevent' : '';
        $prevent_up = ($page == $page_max) ? ' link-prevent' : '';

        $data_section = (is_numeric($id_section) == true) ? 'data-id_section="' . $id_section . '"' : '';

        return $paginateur =
            '<a href="#" class="paginateur-fleche' . $prevent_under . '" ' . $data_section . '> << </a>'
            . '<a href="#" class="paginateur-fleche' . $prevent_under . '" ' . $data_section . $page_under . '> < </a>'
            . '<div class="paginateur-input"><input class="paginateur" placeholder="' . $page . '"> / ' . $page_max . '</div>'
            . '<a href="#" class="paginateur-fleche' . $prevent_up . '" ' . $data_section . $page_up . '> > </a>'
            . '<a href="#" class="paginateur-fleche' . $prevent_up . '" ' . $data_section . ' data-page="' . $page_max . '"> >> </a>';
    }
}
