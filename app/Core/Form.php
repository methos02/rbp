<?php

namespace App\Core;
/**
 * @method string nom($nom, $label, $option = []) retourne un input de data-type nom
 * @method string titre($nom, $label, $option = []) retourne un input de data-type titre
 * @method string license($nom, $label, $option = []) retourne un input de data-type license
 * @method string mdp($nom, $label, $option = []) retourne un input de data-type mdp
 * @method string numb($nom, $label, $option = []) retourne un input de data-type numb
 * @method string numb_rue($nom, $label, $option = []) retourne un input de data-type numb_rue
 * @method string rue($nom, $label, $option = []) retourne un input de data-type rue
 * @method string cp($nom, $label, $option = []) retourne un input de data-type cp
 * @method string ville($nom, $label, $option = []) retourne un input de data-type ville
 * @method string tel($nom, $label, $option = []) retourne un input de data-type tel
 * @method string mail($nom, $label, $option = []) retourne un input de data-type mail
 * @method string site($nom, $label, $option = []) retourne un input de data-type site
 */
class Form
{
    const NOM = 0;
    const LABEL = 1;
    const OPTIONS = 2;
    const WIDTH = ['demi', 'order', 'tier'];
    const DEFAUT_IMG = '/images/empty.png';
    const TYPE = ['mdp' => 'password'];
    const MAGIC_FUNCTION = ['nom', 'titre', 'license', 'numb_rue', 'numb', 'mail', 'mdp', 'rue', 'cp', 'ville', 'tel', 'site'];

    private $data;

    public static function input_text($name, $label, $options = []): void {
        include_file(inputs_path('_text'), compact('name', 'label', 'options'));
    }
    public static function input_select($name, $label, $options, $params = []): void {
        include_file(inputs_path('_select'), compact('name', 'label', 'options', 'params'));
    }
    public static function password($name, $label, $options = []): void {
        include_file(inputs_path('_password'), compact('name', 'label', 'options'));
    }
    public static function file_image($name, $options = []): void {
        $options['src'] = $options['src'] ?? Form::DEFAUT_IMG;
        include_file(inputs_path('_file-image'), compact('name', 'options'));
    }

    public function __construct($data = null) {
        $this->data = $data;
    }

    public static function factoryForm($data = null)
    {
        $instance = new Form($data);

        return $instance;
    }

    /**
     * @param $type string
     * @param $arguments array
     * @return string retour code HTML
     * @throws Exception
     */
    public function __call($dataType, $arguments)
    {
        if (!in_array($dataType, Form::MAGIC_FUNCTION)) {
            throw new Exception('La fonction ' . $dataType . ' est inconnue');
        }

        $options = isset($arguments[Form::OPTIONS]) ? $arguments[Form::OPTIONS] : [];

        return $this->generate_input($arguments[Form::NOM], $arguments[Form::LABEL], $dataType, $options);
    }

    private function generate_input($nom, $label, $dataType, $options)
    {
        $width = isset($options['width']) && in_array($options['width'], Form::WIDTH) ? $options['width'] : '';
        $obliger = isset($options['obliger']) && $options['obliger'] == 1 ? ' data-obliger="1"' : '';
        $message = isset($options['message']) ? ' data-message="' . $options['message'] . '"' : '';
        $addon = isset($options['addon']) ? '<span class="addon-compact">' . $options['addon'] . '</span>' : '';
        $type = key_exists($dataType, self::TYPE) != null ? self::TYPE[$dataType] : 'text';

        return '<label class="label-compact ' . $width . '">'
            . '<input type="' . $type . '" name="' . $nom . '" class="input-compact" data-type="' . $dataType . '" ' . $this->getValue($nom) . $obliger . $message . '>'
            . $addon
            . '<span class="label-input">' . $label . '</span>'
            . '</label>';
    }

    public function select($nom, $label, $options, $params = null): string
    {
        $width = isset($params['width']) && in_array($params['width'], Form::WIDTH) ? $params['width'] : '';
        $obliger = isset($params['obliger']) && $params['obliger'] == 1 ? ' data-obliger="1"' : '';
        $message = isset($params['message']) ? ' data-message="' . $params['message'] . '"' : '';

        $verif = isset($params['verif']) && $params['verif'] == 0 ? '' : 'data-type="select" ';

        $default = isset($params['default']) ? $params['default'] : $this->getValue($nom, true);
        $null = isset($params['null']) && $params['null'] == 1 ? 1 : null;

        $options = (is_array($options)) ? $this->defineOptions($options, ['default' => $default, 'null' => $null]) : $options;


        return '<label class="label-compact ' . $width . '">'
            . '<select name="' . $nom . '" class="input-compact" ' . $verif . $obliger . $message . '>'
            . $options
            . '</select>'
            . '<span class="label-input">' . $label . '</span>'
            . '</label>';
    }

    public function checkbox($nom, $value, $options = null)
    {
        $disabled = isset($options['disabled']) && $options['disabled'] == true ? ' disabled="disabled"' : '';
        $obliger = isset($options['obliger']) && $options['obliger'] == 1 ? ' data-obliger="1"' : '';
        $checked = isset($options['checked']) && $options['checked'] == true ? ' checked="checked"' : '';

        return '<span class="text-center">'
            . '<label><input type="checkbox" name="' . $nom . '" value="' . $value . '" ' . $disabled . $checked . $obliger . '></label>'
            . '</span>';
    }

    public function text($nom, $placeholder, $options = null)
    {
        $width = isset($options['width']) && in_array($options['width'], Form::WIDTH) ? $options['width'] : '';
        $obliger = isset($options['obliger']) && $options['obliger'] == 1 ? ' data-obliger="1"' : '';
        $message = isset($options['message']) ? ' data-message="' . $options['message'] . '"' : '';
        $rows = isset($options['rows']) ? ' rows="' . $options['rows'] . '"' : '';

        return '<label class="label-compact label-text ' . $width . '">'
            . '<textarea name="' . $nom . '" placeholder="' . $placeholder . '" class="text-compact" data-type="texte" ' . $rows . $obliger . $message . '>' . $this->getValue($nom, true) . '</textarea>'
            . '<span class="label-input"></span>'
            . '</label>';
    }

    public function date($nom, $label, $options = [])
    {
        $obliger = isset($options['obliger']) ? 'data-obliger="' . $options['obliger'] . '"' : '';
        $type = isset($options['type']) ? 'data-type="' . $options['type'] . '"' : '';

        return '<label class="border-date" data-nom="' . $nom . '" ' . $type . $obliger . '>'
            . '<span class="label-input"> ' . $label . ' </span>'
            . '<input name="jour_' . $nom . '" type="text" maxlength="2" autocomplete="off" data-type="date" class="date-jm date-j" ' . $this->valueDate('date_' . $nom, 'd') . '>'
            . '<span class="date-separateur">/</span>'
            . '<input name="mois_' . $nom . '" type="text" maxlength="2" autocomplete="off" data-type="date" class="date-jm" ' . $this->valueDate('date_' . $nom, 'm') . '>'
            . '<span class="date-separateur">/</span>'
            . '<input name="annee_' . $nom . '" type="text" maxlength="4" autocomplete="off" data-type="date" class="date-a" ' . $this->valueDate('date_' . $nom, 'Y') . '>'
            . '</label>';
    }

    public function heure($nom, $label, $options = [])
    {
        $obliger = isset($options['obliger']) ? 'data-obliger="' . $options['obliger'] . '"' : '';

        return '<label class="border-heure" data-nom="' . $nom . '" ' . $obliger . '>'
            . '<span class="label-input">' . $label . '</span>'
            . '<input name="heure_' . $nom . '" type="text" maxlength="2" autocomplete="off" data-type="heure" class="input-heure" ' . $this->valueDate('heure_' . $nom, 'H') . '>'
            . '<span class="heure-separateur">:</span>'
            . '<input name="minute_' . $nom . '" type="text" maxlength="2" autocomplete="off" data-type="heure" class="input-minute" ' . $this->valueDate('heure_' . $nom, 'i') . '>'
            . '</label>';
    }

    public function fileImg($nom, $label, $options = [])
    {
        $width = isset($options['width']) && in_array($options['width'], Form::WIDTH) ? ' ' . $options['width'] : '';
        $obliger = isset($options['obliger']) && $options['obliger'] == 1 ? ' data-obliger="1"' : '';
        $img_defaut = isset($options['defaut']) ? $options['defaut'] : Form::DEFAUT_IMG;
        $source = isset($this->data[$nom]) ? $this->data[$nom] : $img_defaut;
        $option = isset($options['option']) ? 'data-option="' . $options['option'] . '"' : '';

        return '<div class="text-center row-pad' . $width . '">'
            . '<label class="label-file">'
            . '<img src="' . $source . '" alt="Apperçu Logo" class="appercu-img" data-appercu>'
            . '<span class="label-input text-center" data-fileName> Aucun fichier </span>'
            . '<input type="file" name="' . $nom . '" data-type="file" data-accept="img" ' . $option . $obliger . ' style="display: none;">'
            . '</label>'
            . '<button class="btn btn-default btn-file" data-file="' . $nom . '"> ' . $label . ' </button>'
            . '</div>';
    }

    public function filePdf($nom, $label, $options = [])
    {
        $width = isset($options['width']) && in_array($options['width'], Form::WIDTH) ? $options['width'] : '';
        $obliger = isset($options['obliger']) && $options['obliger'] == 1 ? ' data-obliger="1"' : '';
        $fileName = isset($this->data[$nom]) ? $this->data[$nom] : 'Aucun fichier';

        return '<div class="text-center ' . $width . '">'
            . '<label class="label-compact label-file">'
            . '<div class="row-pad"><strong>' . $label . '</strong></div>'
            . '<span class="label-input text-center" data-fileName>' . $fileName . '</span>'
            . '<input type="file" name="' . $nom . '" data-type="file" data-accept="pdf" ' . $obliger . ' style="display: none;">'
            . '</label>'
            . '<button class="btn btn-default btn-file" data-file="' . $nom . '"> Choisissez un fichier </button>'
            . '</div>';
    }

    public function datalist($nom, $label, $liste = "", $options = [])
    {
        $width = isset($options['width']) && in_array($options['width'], Form::WIDTH) ? $options['width'] : '';
        $obliger = isset($options['obliger']) && $options['obliger'] == 1 ? ' data-obliger="1"' : '';
        $message = isset($options['message']) ? ' data-message="' . $options['message'] . '"' : '';
        $btnReset = isset($options['reset']) && $options['reset'] == true ? '<button data-action="datalist_reset"><span class="glyphicon glyphicon-trash" style="color: red"></span></button>' : '';

        return '<label class="label-compact ' . $width . (isset($options['reset']) && $options['reset'] == true ? 'datalist-reset' : '') . '">'
            . '<input type="text" name="' . $nom . '" class="input-compact" title="liste-' . $nom . '" id="liste-' . $nom . '" list="' . $nom . '" data-page="' . $nom . '" data-type="datalist" autocomplete="off" ' . $this->getValue($nom) . $message . $obliger . '>'
            . $btnReset
            . '<datalist id="' . $nom . '" data-type="datalist">' . $liste . '</datalist>'
            . '<input type="hidden" name="id_' . $nom . '" ' . $this->getValue('id_' . $nom) . '>'
            . '<span class="label-input"> ' . $label . ' </span>'
            . '</label>';
    }


    public function defineOptions(array $array, array $params = null): string
    {
        $default = isset($params['default']) ? $params['default'] : null;

        $options = isset($params['null']) && $params['null'] == 1 ? '<option value="-1">------</option>' : '';

        foreach ($array as $key => $value) {
            $options .= '<option value="' . $key . '" ' . ($key == $default ? 'selected="selected"' : '') . '>' . $value . '</option>';

        }

        return $options;
    }

    public function defineOptionDatalist(array $array, string $name): string
    {
        $options = '';

        foreach ($array as $id => $value) {
            $options .= '<option data-id_' . $name . '="' . $id . '">' . $value . '</option>';
        }

        return $options;
    }

    public function getValue($key, $pure = false)
    {
        if (is_array($this->data) && key_exists($key, $this->data)) {
            return $pure == true ? $this->data[$key] : 'value="' . $this->data[$key] . '"';
        }

        return "";
    }

    public function valueDate($name, $key)
    {
        if (is_array($this->data) && key_exists($name, $this->data) && !empty($this->data[$name])) {
            $date = new DateTime($this->data[$name]);
            return 'value="' . $date->format($key) . '"';
        }

        return "";
    }
}
