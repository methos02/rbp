<?php
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
function include_file(string $file_path, array $datas = []): void {
    try {
        if(!file_exists($file_path)) throw new Exception('File introuvable');
        extract($datas);
        include $file_path;
    } catch (Exception $e) {
        include exception_path();
    }
}
