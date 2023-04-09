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
</head>