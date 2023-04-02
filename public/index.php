<?php
use App\Core\Router\Router;

include dirname(__DIR__).'/includes/init.php';

include_file(routes_path('routes'));

try {
    Router::setUrl($_GET['url']);
    Router::run();
} catch (Exception $e) {
    include exception_path();
}
