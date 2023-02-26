<?php
use Connection\Connection;
class Photo extends Table {
    CONST PHOTO_PATH = '/photo/';
    CONST PHOTO_REAL_PATH = 'images/photo/';
    CONST SIZE_MAX = 500000;

    CONST ERREUR = [
        UPLOAD_ERR_INI_SIZE => 'La photo es trop volumineuse.'
    ];

    public static function factory() {
        $dbb = Connection::getInstance();
        $instance = new Photo($dbb);

        return $instance;
    }

    public function addAlbum ($nom, $slug, $id_saison, $id_section) {
        $this -> bdd -> req('INSERT INTO t_album (alb_nom, alb_slug, alb_id_saison, alb_id_section, alb_nom_creation, alb_date_creation) VALUES (:nom, :slug, :id_saison, :id_section, :nom_creation, NOW())', array('nom' => $nom, 'slug' => $slug, 'id_saison' => $id_saison, 'id_section' => $id_section, 'nom_creation'=> $_SESSION['auth']['user']));
        return $this->bdd->last();
    }

    public function addPhoto ($photo, $id_album) {
        $this->bdd->req('INSERT INTO t_photo (pho_photo, pho_id_album, pho_nom_modif, pho_date_modif) VALUES (:photo, :id_album, :nom_modif, NOW())', array('photo'=>$photo, 'id_album'=>$id_album, 'nom_modif' => $_SESSION['auth']['user']));
    }

    public function updateAlbum ($id_album, $nom, $slug, $id_saison, $id_section) {
        $update = $this->bdd->req('UPDATE t_album SET alb_nom = :nom, alb_slug = :slug, alb_id_saison = :id_saison, alb_id_section = :id_section, alb_nom_modif = :nom_modif, alb_date_modif = NOW() WHERE alb_id = :id_album', array('id_album' => $id_album, 'nom' => $nom, 'slug' => $slug, 'id_saison' => $id_saison, 'id_section' => $id_section, 'nom_modif' => $_SESSION['auth']['user']));
        return $update->rowCount();
    }

    public function definePhotoCover ($id_album, $cover) {
        $update = $this->bdd->req('UPDATE t_album SET alb_cover = :cover, alb_nom_modif = :nom_modif, alb_date_modif = NOW() WHERE alb_id = :id_album', array('id_album' => $id_album, 'cover' => $cover, 'nom_modif' => $_SESSION['auth']['user']));
        return $update->rowCount();
    }

    public function suppPhoto ($nom) {
        $supp = $this->bdd->req('UPDATE t_photo SET pho_supplogique = 1, pho_nom_modif = :nom_modif, pho_date_modif = NOW() WHERE pho_photo = :nom', array('nom' => $nom, 'nom_modif' => $_SESSION['auth']['user']));
        return $supp->rowCount();
    }

    public function suppPhotos ($id_album) {
        $supp = $this->bdd->req('UPDATE t_photo SET pho_supplogique = 1, pho_nom_modif = :nom_modif, pho_date_modif = NOW() WHERE pho_id_album = :id_album', array('id_album' => $id_album, 'nom_modif' => $_SESSION['auth']['user']));
        return $supp->rowCount();
    }

    public function suppAlbum ($id_album) {
        $supp = $this->bdd->req('UPDATE t_album SET alb_supplogique = 1, alb_nom_modif = :nom_modif, alb_date_modif = NOW() WHERE alb_id = :id_album', array('id_album' => $id_album, 'nom_modif' => $_SESSION['auth']['user']));
        return $supp->rowCount();
    }

    public function getAlbum($id_album) {
        return $this->bdd->reqSingle('SELECT alb_id as id_album, alb_nom as nom, alb_slug as slug, alb_cover as cover, alb_id_section as id_section, alb_id_saison as id_saison, alb_nom_creation as nom_creation, alb_date_creation as date_creation, alb_supplogique as supp FROM t_album WHERE alb_id = :id_album', array('id_album' => $id_album));
    }

    public function getAlbumBySlug($slug) {
        return $this->bdd->reqSingle('SELECT alb_id as id_album FROM t_album WHERE alb_slug = :slug', ['slug' => $slug]);
    }

    public function getAlbumsBySaison_Section($id_saison, $id_section) {
        return $this->bdd->reqMulti('SELECT alb_id, alb_nom, alb_cover, alb_slug FROM t_album WHERE alb_id_saison = :id_saison AND alb_id_section = :id_section AND alb_supplogique = 0', array('id_saison' => $id_saison, 'id_section' => $id_section));
    }

    public function getPhotoAndAlbumCoverByName($nom) {
        return $this->bdd->reqSingle('SELECT pho_photo, alb_cover FROM t_photo 
                                       INNER JOIN t_album ON alb_id = pho_id_album
                                       WHERE pho_photo = :nom', ['nom' => $nom]);
    }

    public function getPhotoByName($photo) {
        return $this->bdd->reqSingle('SELECT pho_id FROM t_photo WHERE pho_photo = :photo AND pho_supplogique = 0', array('photo' => $photo));
    }

    public function getPhotos($id_album) {
        return $this->bdd->reqMulti('SELECT pho_photo as photo FROM t_photo WHERE pho_id_album = :id_album AND pho_supplogique = 0', array('id_album' => $id_album));
    }

    public function getLastSaisonAlbum($id_section) {
        $id_saison = $this->bdd->reqSingle('SELECT MAX(alb_id_saison) as id_saison FROM t_album WHERE alb_id_section = :id_section AND alb_supplogique = 0', array('id_section' => $id_section));
        return $id_saison['id_saison'];
    }

    public function getOptionSaisonAlbumBySection($saisons, $id_saison = null){
        if(empty($saisons)) {return '<option value="-1"> ------ </option>';}

        $option = '';

        foreach ($saisons as $saison){
            $option .= '<option value="' . $saison['id_saison'] . '" ' . (($id_saison == $saison['id_saison'])?'selected="selected"':'') .'>' . $saison['saison'] . '</option>';
        }

        return $option;
    }

    public function orderListeAlbum($albums){
        $li = '';
        foreach ($albums as $album) {
            $li .=  '<li class="li-album reference" data-id_album="' . $album['alb_id'] . '" ><span class="album-name">'.$album['alb_nom'].'</span>'.Core_rbp::generateBtnManage('album', $album['alb_id']).'</li>';
        }

        return '<ul class="row-pad ul-album">'.$li.'</ul>';
    }

    public function orderAlbum($albums) {
        $affiche = '';
        $i_picture = 0;
        foreach ($albums as $album) {

            if(!file_exists(__DIR__ . '/../' . Photo::PHOTO_REAL_PATH . $album['alb_cover']) || $album['alb_cover'] == null) {continue;}

            if($i_picture != 0 && $i_picture % 4 == 0) {
                $affiche .= '</div><div class="row">';
            }

            $affiche .= '<div class="col-md-3 border-album">'
                .           '<div class="limite-album reference">
                                <div class="div-album" data-slug="' . $album['alb_slug'] . '" style="background:url('. Photo::PHOTO_PATH . $album['alb_cover'] .')"></div>'
                .           '<a class="a-album">' . $album['alb_nom'] . '</a></div>'
                .       '</div>';

            $i_picture ++;
        }

        return '<div class="row">'.$affiche.'</div>';
    }

    function compress($source, $quality) {

        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        imagejpeg($image, $source, $quality);
    }

    function resize($source, $new_width, $new_height, $width, $height) {
        $info = getimagesize($source);

        if ($info['mime'] == 'image/jpeg')
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif')
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png')
            $image = imagecreatefrompng($source);

        $image_resize = imagecreatetruecolor($new_width, $new_height);

        imagecopyresized($image_resize, $image, 0 , 0,0, 0, $new_width, $new_height, $width, $height);

        imagejpeg($image_resize, $source);
    }

    function defineNewSize($width, $height, $img_size, $finale_size) {

        $nbPixel = $width * $height;
        $new_nbPixel = ($nbPixel * $finale_size) / $img_size;
        $proportion = $height / $width;

        $new_height = sqrt ( $new_nbPixel *  $proportion);
        $new_width = $new_height / $proportion;

        return ['width' => $new_width, 'height' => $new_height];
    }
}