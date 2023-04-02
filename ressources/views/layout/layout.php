<?php
use App\Helpers\Auth;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="HandheldFriendly" content="true" />

    <link rel="icon" type="image/png" href="<?= images_url('icon.jpg') ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= css_url('rbp.css') ?>">

    <?php if(stripos($_SERVER['SCRIPT_NAME'], 'photo_manage') !== false ){ echo '<link rel="stylesheet" href="/dropzone.css">';}?>
    <?php if(stripos($_SERVER['SCRIPT_NAME'], 'photo.') !== false ){ echo '<link rel="stylesheet" href="/lightgallery.min.css">';}?>
    <title><?php if(isset($meta['nom'])){ echo $meta['nom']; } else {echo 'Royals Brussels Poseidon'; } ?></title>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous" defer></script>
    <script src="https://cdn.ckeditor.com/4.20.2/basic/ckeditor.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous" defer></script>
    <?php if (Auth::can(Droit::REDAC)): ?>
        <script src="<?= js_url('admin.js') ?>" defer></script>
    <?php endif; ?>
    <?php if (str_contains($_SERVER['PHP_SELF'], 'photo')) : ?>
        <script src="<?= js_url('lightgallery.min.js') ?>" defer></script>
        <script src="<?= js_url('js/lg-thumbnail.min.js') ?>" defer></script>
    <?php endif; ?>
    <script src="<?= js_url('core.js') ?>" defer></script>
    <script src="<?= js_url('form.js') ?>" defer></script>
    <?= vite('js/app.js') ?>
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
