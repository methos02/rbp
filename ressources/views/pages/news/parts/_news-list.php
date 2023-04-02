<?php
if(!isset($news_list)) { echo 'La variable news_list est inconnue'; return;}

foreach ($news_list as $news) :
    include_file(views_path('pages/news/parts/_news-short.php'), compact('news'));
endforeach;
