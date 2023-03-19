<?php

use App\Models\News;

$news_datas = [
    [
        'title' => 'Première news',
        'content' => "C'est une première news",
        'picture' => News::IMG_DEFAULT_WP,
        'created_by' => 'LEON Frédéric',
        'created_at' => '15-02-23',
        'section_id' => 1,
    ],
    [
        'title' => 'Seconde news',
        'content' => "C'est une seconde news",
        'picture' => News::IMG_DEFAULT_NAT,
        'created_by' => 'Istiry Anne',
        'created_at' => '05-03-23',
        'section_id' => 1,
    ]
];

foreach ($news_datas as $news_data) {
    if(!News::create($news_data)) { echo "Problème avec le seeder de la news {$news_data['title']}"; break; }
}
