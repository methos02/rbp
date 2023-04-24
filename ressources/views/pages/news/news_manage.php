<?php

use App\Core\Form;
use App\Core\Request;
use App\Core\Auth;
use App\Models\News;

$meta['nom'] = 'Royal Brussels Poseidon - Ajouter une news';

ob_start();
?>
    <div class="contenu container">
        <h4 class="bg-primary h4-size row-pad"><?= (isset($news)?'Modification ': 'Nouvelle ') ?> News</h4>
        <form name="form-news" method="post" action="/news<?= (isset($news))? '/'.$news->get('id') : ''; ?>" data-validate="news_form">
            <div class="row-flex">
                <?php Form::input_select('section_id', 'Section :', Section::select_options()) ?>
                <?php Form::input_text('title', 'Titre') ?>
            </div>
            <div class="row-flex">
                <label class="label-compact label-text">
                    <textarea id="content" name="content" data-library="cke_editor"></textarea>
                </label>
                <?php Form::file_image('picture') ?>
            </div>
            <button type="submit" class="btn btn-primary">Publier</button>
        </form>
    </div>
<?php
$content = ob_get_clean();

include views_path('layout\layout.php');
