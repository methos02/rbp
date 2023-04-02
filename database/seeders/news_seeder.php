<?php

use App\Models\News;
use Carbon\Carbon;

$faker = Faker\Factory::create();
$news_count = 50;

for($i = 0; $i < $news_count; $i++) {
    $section_id = $faker->numberBetween(1,4);
    $news_data = [
        'title' => 'news '. $i,
        'content' => $faker->text(),
        'picture' => News::getDefaultImage($section_id),
        'created_by' => $faker->randomElement(['ISTIRY Anne', 'LEON Frédéric']),
        'created_at' => Carbon::now()->subDays($news_count - $i)->format('d-m-y'),
        'section_id' => $section_id,
    ];

    if(!News::create($news_data)) { echo "Problème avec le seeder de la news {$news_data['title']}"; break; }
    echo "news $i seedée ... \n";
}
