<?php
use App\Helpers\Html;
if(!isset($name, $label)) return '';
?>
<div class="form-input">
    <label for="<?= $name ?>"<?= isset($options['required']) ?' class="required"' : "" ?>> <?= $label ?> </label>
    <input id="<?= $name ?>" type="<?= $options['type'] ?? "text" ?>" name="<?= isset($options['array']) ? $options['array'] . '[' . $name . ']' : $name  ?>" class="input"{!! $options['attributes'] ?? "" !!}>
    <?php if(isset($_SESSION['errors'][$name])) echo Html::error($_SESSION['errors'][$name], $name); ?>
</div>
