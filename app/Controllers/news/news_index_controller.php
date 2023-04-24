<?php

use App\Core\Request;
use App\Core\Response;
use App\Models\News;

$section_condition = !is_null(Request::get('section')) ? ['section_id' => Section::get('id', Request::get('section'))] : [];
$news_list = News::where(array_merge(['status' => News::S_VALIDE], $section_condition))->order('created_at', 'DESC')->paginate(News::PER_PAGE);
$news_count = News::where(array_merge(['status' => News::S_VALIDE], $section_condition))->count();

if(Request::isAjax()) {
    return Response::json([
        'news_list' => views_render('pages/news/parts/_news-list', compact('news_list')),
        'paginator' => views_render('components/paginator', ['count' => $news_count, 'per_page' => News::PER_PAGE])
    ]);
}

include_file(views_path('pages/news/news_index'), [ 'news_count' => $news_count, 'news_list' => $news_list ]);
