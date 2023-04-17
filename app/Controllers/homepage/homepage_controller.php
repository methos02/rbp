<?php
use App\Models\News;

include_file(views_path('pages/homepage/homepage'), [ 'news_list' => News::limit(2)->get() ]);
