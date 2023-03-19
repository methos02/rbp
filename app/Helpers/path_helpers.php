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
    return getcwd().$file;
}
function routes_path($file = ""): string {
    return project_path("\\routes\\".$file);
}
function views_path($file = ""): string {
    return project_path("\\ressources\\views\\".$file);
}
function include_file(string $file_path): void {
    try {
        if(!file_exists($file_path)) throw new Exception('File introuvable');
        include $file_path;
    } catch (Exception $e) {
        include exception_path();
    }
}
