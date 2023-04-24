<?php

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Models\News;

$datas = Request::validate('auth/news_request', '/news/create');
News::create(array_merge($datas, [
    'created_by' => Auth::user()->getFullName()
]));

//    $photoName = $newsFactory->move_file('photo', News::PATH_IMG_REAL);
//    $result['statut'] = $mailFactory->sendMailNews($_POST['titre']);

Response::redirectWithFlash('/news', ['type' => 'success', 'title' => 'La news a bien été créée.']);
