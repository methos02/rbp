<?php

use App\Core\Router\Router;

Router::get('', 'pages/homepage/homepage');
Router::get('news', 'pages/news/news_list');
Router::get('news/:section', 'pages/news/news_list');
