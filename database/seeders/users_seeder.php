<?php

use App\Models\User;

$user_data = [
    'firstname' => 'john',
    'lastname' => 'doe',
    'email' => 'john_doe@rbp.be ',
    'password' => '1234',
    'roles' => 'admin',
];

if(!User::create($user_data)) { echo "Problème avec le seeder du user john_doe"; return; }
echo "user John Doe seedé ... \n";

$user_data = [
    'firstname' => 'jane',
    'lastname' => 'doe',
    'email' => 'jane_doe@rbp.be ',
    'password' => '1234',
    'roles' => 'admin',
];

if(!User::create($user_data)) { echo "Problème avec le seeder du user jane_doe"; return; }
echo "user Jane Doe seedé ... \n";

