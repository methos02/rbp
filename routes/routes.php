<?php

use App\Core\Router\Router;

Router::get('', 'homepage.homepage');

Router::get('login', 'homepage.homepage');
Router::post('login', 'auth.login');

Router::get('news', 'news.news_index');
Router::get('news/:section', 'news.news_index')->with('section', '([a-z]+)');
Router::get('news/:news_id', 'news.news_show')->with('news_id', '[0-9]+');
