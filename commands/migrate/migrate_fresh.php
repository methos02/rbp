<?php

use App\Core\Connection;

$pdo = Connection::getInstance(Connection::FRESH);

$pdo->exec('DROP DATABASE IF EXISTS rbp;');
$pdo->exec('CREATE DATABASE rbp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; USE rbp;');

echo "Début des migrations ... \n";

$migrations = scandir(database_path('bases'));
if(!$migrations) { echo 'Le path des migrations est invalide'; return; }

foreach ($migrations as $migration) {
    if (in_array($migration,[".",".."])) continue;

    $pdo->exec(include database_path('bases/'.$migration));
    echo "$migration migrée ... \n";
}

echo "... migration terminée. \n Début des seeders ... \n";
foreach (include database_path('seeders/seeder.php') as $seeder) {
    include database_path("seeders/{$seeder}_seeder.php");
    echo "Seeder $seeder terminé ... \n";
}
echo "... seeders terminés. \n";
