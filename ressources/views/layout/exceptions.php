<?php

if(!isset($e)) { echo 'Erreur introuvable'; return; }
ob_start();
?>
    <h1>Exception a été levée</h1>
    <h2>Type</h2>
    <p><?= get_class($e) ?></p>
    <h2>message</h2>
    <p><?= $e->getMessage() ?></p>
    <h2>Files</h2>
    <p><?= $e->getFile() ?> ligne <?= $e->getLine() ?></p>
    <h2>Files</h2>
<?php foreach ($e->getTrace() as $trace) : ?>
    <p>Files : <?= $trace['file'] ?> ligne <?= $trace['line'] ?></p>
<?php endforeach; ?>
<?php

$content = ob_get_clean();

include views_path('layout\layout.php');
