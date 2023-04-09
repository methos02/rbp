<?php

use App\Core\Router\Router;

Router::get('', 'pages/homepage/homepage');
Router::get('news', 'pages/news/news_list');
Router::get('news/:section', 'pages/news/news_list')->with('section', '([a-z]+)');
Router::get('news/:news_id', 'pages/news/news_show')->with('news_id', '[0-9]+');
