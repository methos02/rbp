<?php
if(!isset($name, $options)) return '';
?>
<div class="text-center">
    <label class="label-file" for="<?= $name ?>">
        <img src="<?= $options['src'] ?>" alt="Aperçu de l'image" data-preview="<?= $name ?>" onclick="document.getElementById('<?= $name ?>').click()">
        <button class="btn btn-default btn-file" onclick="document.getElementById('<?= $name ?>').click()">Sélectionnez une image</button>
    </label>
    <input type="file" id="<?= $name ?>" name="<?= $name ?>" data-preview="<?= $name ?>" style="display: none">
</div>
