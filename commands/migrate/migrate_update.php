<?php

use App\Core\Connection;

$pdo = Connection::getInstance(Connection::FRESH);
$pdo->exec('USE rbp;');


echo "Début des migrations ... \n";

$migrations = scandir(database_path('migrations'));
if(!$migrations) { echo 'Le path des migrations est invalide'; return; }

foreach ($migrations as $migration) {
    if (in_array($migration,[".",".."])) continue;

    $pdo->exec(include database_path('migrations/'.$migration));
    echo "$migration migrée ... \n";
}

echo "... migration terminée. \n";
