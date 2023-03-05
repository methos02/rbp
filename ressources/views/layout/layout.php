<?php
use App\Helpers\Auth;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="HandheldFriendly" content="true" />
    <link rel="icon" type="image/png" href="/images/icone.jpg">
    <link rel="stylesheet" href="/bootstrap.min.css">
    <link rel="stylesheet" href="/rbp.css">
    <?php if(stripos($_SERVER['SCRIPT_NAME'], 'photo_manage') !== false ){ echo '<link rel="stylesheet" href="/dropzone.css">';}?>
    <?php if(stripos($_SERVER['SCRIPT_NAME'], 'photo.') !== false ){ echo '<link rel="stylesheet" href="/lightgallery.min.css">';}?>
    <title><?php if(isset($meta['nom'])){ echo $meta['nom']; } else {echo 'Royals Brussels Poseidon'; } ?></title>

    <script src="/jQuery.js" defer></script>
    <script src="/vendor/ckeditor/ckeditor.js" defer></script>
    <script src="/vendor/ckeditor/adapters/jquery.js" defer></script>
    <script src="/bootstrap.min.js" defer></script>
    <?php if (Auth::can(Droit::REDAC)): ?>
        <script src="/admin.js" defer></script>
    <?php endif; ?>
    <?php if (str_contains($_SERVER['PHP_SELF'], 'photo')) : ?>
        <script src="/lightgallery.min.js" defer></script>
        <script src="/lg-thumbnail.min.js" defer></script>
    <?php endif; ?>
    <script src="/core.js" defer></script>
    <script src="/form.js" defer></script>
</head>
<body class="no-sectionBarre">
<div class="container-fluid">
    <?php include views_path('layout/navbar.php') ?>
    <?= $content ?? '' ?>
</div>
<footer <?php if(isset($footer)){echo $footer;} ?>>
    <div class="col-md-6"> © Copyright 2013 - <?= date('Y')?> Royal Brussels Poseidon. Tous droits réservés. </div>
    <div class="col-md-6 text-right">Créé par <a href="#">LEON Frédéric</a></div>
</footer>
</body>
</html>
