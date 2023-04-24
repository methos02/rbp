<?php
use App\Helpers\Html;
if(!isset($name, $label, $options)) return '';
?>
<div class="form-input">
    <label for="<?= $name ?>"<?= isset($options['required']) ?' class="required"' : "" ?>> <?= $label ?> </label>
    <select id="<?= $name ?>" name="<?= isset($options['array']) ? $options['array'] . '[' . $name . ']' : $name  ?>" class="input"<?= $options['attributes'] ?? "" ?>>
        <?php foreach ($options as $key => $value): ?>
            <option value="<?= $key ?>"><?= $value ?></option>
        <?php endforeach; ?>
    </select>
    <?= Html::error($name); ?>
</div>
