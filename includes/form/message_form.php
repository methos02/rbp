<?php

use App\Core\Form;

$mailFactory = Mail::factory();
$contactForm = Form::factoryForm();
?>
<form name="form-contact" data-action="contact">
    <div class="row-flex">
        <?= $contactForm->select('id_destinataire', 'Destinataire', Mail::ARR_CONTACT_ID_TO_NAME, ['obliger' => 1])?>
        <?= $contactForm->mail('mail', 'Votre mail', ['obliger' => 1, 'width' => 'order']) ?>
    </div>
    <div class="row-flex">
        <?= $contactForm->titre('sujet', 'Sujet', ['obliger' => 1, 'width' => 'order']) ?>
    </div>
    <div class="row-flex">
        <?= $contactForm->text('message', 'Message', ['obliger' => 1, 'width' => 'order', 'rows' => 8]) ?>
    </div>
    <div class="text-center">
        <input name="submit" type="submit" class="btn btn-default" data-verif="form-contact" value="Envoyer">
    </div>
</form>
