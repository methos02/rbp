<?php
use App\Helpers\Html;
if(!isset($name, $label)) return '';
?>
<div class="form-input">
    <label for="<?= $name ?>"<?=isset($options['required']) ?' class="required"' : ""?>> <?= $label ?> </label>
    <div class="input-password">
        <input id="<?= $name ?>" type="password" name="<?= isset($options['array']) ? $options['array'] . '[' . $name . ']' : $name ?>" class="input" value="">
        <button class="input-password_icon" data-password="show"> <i class="glyphicon glyphicon-eye-open"></i></button>
    </div>
    <?php if(isset($_SESSION['errors'][$name])) echo Html::error($_SESSION['errors'][$name], $name); ?>
</div>
