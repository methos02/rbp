<?php

function include_file(string $file_path, array $datas = []): void {
    try {
        if(!file_exists($file_path)) throw new Exception('File introuvable');
        extract($datas);
        include $file_path;
    } catch (Exception $e) {
        include exception_path();
    }
}

function views_render($file_path, array $data = []):string {
    ob_start();
    include_file(views_path($file_path . '.php'), $data);
    return ob_get_clean();
}
