<?php
class Core_rbp {
    static $BDD;
    CONST COTISATION = 300;
    CONST URL_CAPTCHA = 'https://www.google.com/recaptcha/api/siteverify?secret='.SECRET_CLE.'&response=';

    public static function icon($icon, $color) {
        return '<span class="glyphicon glyphicon-'.$icon.'" style="color:'.$color.'"></span>';
    }

    public static function view($url, $params = null) {
        $url = __DIR__ . '/../' . $url . '.php';

        if(!file_exists($url)) {
            return self::flashHTML('danger', 'La page est introuvable');
        }

        ob_start();
        extract($params);
        require ($url);
        return ob_get_clean();
    }

    public static function generateBtnManage(string $item, int $id_item, string $url = null): string {
        $modifPart = $url != null ? 'href="'. $url . '"' : 'href="#" data-manage="' . $item . '"';
        $link = '<a ' . $modifPart . ' class="margin-left">'.self::icon('pencil', '#24aa2d').'</a>';

        $data = 'data-supp="' . $item . '"';
        $span_data = 'data-id_' . $item . '="'. $id_item . '"';

        return  self::generateConfirmeBtn('trash', 'red', $data, compact('link', 'span_data'));
    }

    public static function generateConfirmeBtn(string $icon, string $color, string $data, array $param = []): string {
        $btns =  '<span class="btn-modif"  data-groupe="supp" ' . (isset($param['span_data']) ? $param['span_data'] : '') . ' >'
            .       (isset($param['link']) ? $param['link'] : '')
            .       '<a href="#" data-change="supp" class="margin-left">'.self::icon($icon, $color).'</a>'
            .    '</span>'
            .    '<span data-groupe="supp" style="display: none">'
            .       '<a href="#" ' . $data . ' class="margin-left">'.self::icon('ok', '#24aa2d').'</a>'
            .       '<a href="#" data-change="supp" class="margin-left">'.self::icon('remove', 'red').'</a>'
            .   '</span>';

        return '<span data-div="confirm">' . $btns . '</span>';
    }

    public static function prepareCurl($url) {
        $user_agent = "Mozilla/5.0 (X11; Linux i686; rv:24.0) Gecko/20140319 Firefox/24.0 Iceweasel/24.4.0";

        $curl = curl_init();
        CURL_SETOPT($curl, CURLOPT_URL, $url);
        CURL_SETOPT($curl, CURLOPT_USERAGENT, $user_agent);
        CURL_SETOPT($curl, CURLOPT_RETURNTRANSFER, True);
        CURL_SETOPT($curl, CURLOPT_FOLLOWLOCATION, True);
        CURL_SETOPT($curl, CURLOPT_CONNECTTIMEOUT, 30);
        CURL_SETOPT($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        return curl_exec($curl);
    }

    public static function visiteur(){
        self::$BDD = \Connection\Connection::getInstance();
        self::$BDD->req('UPDATE t_info SET inf_visiteur = inf_visiteur + 1');
    }

    public static function getCategorieBtn($id_saison, $id_categorie){
        self::$BDD = \Connection\Connection::getInstance();

        $categories = self::$BDD->reqMulti('SELECT cat_categorie, cat_ID FROM t_equipe_saison
                                              INNER JOIN t_categorie ON equ_ID_categorie = cat_ID 
                                              WHERE equ_ID_saison = :id_saison ORDER BY cat_ID DESC', array('id_saison'=>$id_saison));

        $btn = '';
        foreach ($categories as $categorie){
            $color = ($id_categorie == $categorie['cat_ID'])?'btn-default btn-primary' : 'btn-default';
            $btn .= '<button class="btn '.$color.' btn-sm btn-categorie" data-ID_cat="'.$categorie['cat_ID'].'">'.$categorie['cat_categorie'].'</button>';
        }

        return $btn;
    }

    public static function emptyResult($message) {
        return '<div class="empty-result">' . $message . '</div>';
    }

    public static function flash($type, $titre, $message = '' ){
        return  '<div class="alert alert-'.$type.' message-unique" style="display:none" id="message-flash">'
            .       '<div class="message-title">'.$titre.'</div>'
            .       '<div class="message-content">'.$message.'</div>'
            .       '<a href="" class="message-close" data-action="message-close"><span class="glyphicon glyphicon-remove" ></span></a>'
            .   '</div>';
    }

    public static function flashHTML($type, $titre, $message = '' ){
        return  '<div class="alert alert-'.$type.' text-center">'
            .       '<div class="message-title">'.$titre.'</div>'
            .       '<div class="message-content">'.$message.'</div>'
            .   '</div>';
    }
}