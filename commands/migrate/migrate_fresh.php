<?php

use App\Core\Connection;

$pdo = Connection::getInstance(Connection::FRESH);

$pdo->exec('DROP DATABASE IF EXISTS rbp;');
$pdo->exec('CREATE DATABASE rbp CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; USE rbp;');

echo "Début des migrations ... \n";
foreach (scandir(database_path('bases')) as $migration) {
    if (in_array($migration,[".",".."])) continue;

    $pdo->exec(include database_path('bases/'.$migration));
    echo "$migration migrée ... \n";
}
