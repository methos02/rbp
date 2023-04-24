<?php

use App\Core\Auth;
use App\Core\Response;

if(!Auth::is_log()){ Response::redirectWithFlash('homepage', ['danger' => 'Vous devez être connecté pour accéder a cette page']);}

include_file(views_path('pages/news/news_manage'));
