<?php

use App\Core\Response;
use App\Models\News;

if(!isset($_GET['news_id']) || !is_numeric($_GET['news_id'])) return Response::json(['error' => "L'id de la news est invalide."], 400);

$news = News::find($_GET['news_id']);
if ($news == null) return Response::json(['error' => "La news est introuvable."], 404);

return Response::json([
    'news' => views_render('pages/news/news_show', compact('news'))
]);
