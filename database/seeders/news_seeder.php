<?php

use App\Models\News;

News::create([
    'news_titre' => 'Première news',
    'news_news' => "C'est une première news",
    'news_photo' => News::IMG_DEFAULT_WP,
    'news_nom_posteur' => 'LEON Frédéric',
    'news_date_p' => '15-02-23',
    'news_ID_section' => 1,
]);

News::create([
    'news_titre' => 'Seconde news',
    'news_news' => "C'est une seconde news",
    'news_photo' => News::IMG_DEFAULT_NAT,
    'news_nom_posteur' => 'Istiry Anne',
    'news_date_p' => '05-03-23',
    'news_ID_section' => 1,
]);


