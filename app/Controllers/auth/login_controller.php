<?php
use App\Core\Request;
use App\Core\Response;
use App\Models\User;

$datas = Request::validate('auth/login_request', '/login');

$user = User::where(['email' => $datas['email']])->first();

if(empty($user)) Response::redirectWithError('/login', ['login' => 'Adresse mail ou mot de passe invalide.']);
if(!password_verify($datas['password'], $user->get('password'))) Response::redirectWithError('/login', ['login' => 'Adresse mail ou mot de passe invalide.']);

$_SESSION['auth']['token'] = $user->get('token');
$_SESSION['auth']['email'] = $user->get('email');
$_SESSION['flash'] = ['type' => 'success', 'title' => 'Vous êtes bien connecté.'];

header('Location: '.$_SERVER["HTTP_REFERER"] );
