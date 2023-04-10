<?php
function controller_path($file = ""): string {
    return project_path("\\app\\Controllers\\".$file);
}
function database_path($file = ""): string {
    return project_path("\\database\\".$file);
}
function exception_path():string {
    return views_path('layout/exceptions.php');
}
function includes_path($file = ""): string {
    return project_path("\\includes\\".$file);
}
function project_path($file = ""):string {

    return (!is_null($_SERVER['REQUEST_METHOD'])? dirname(getcwd()) : getcwd()).$file;
}
function routes_path($file = ""): string {
    return project_path("\\routes\\".$file);
}
function views_path($file = ""): string {
    return project_path("\\ressources\\views\\".$file);
}
