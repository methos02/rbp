<?php

function include_file(string $file_path, array $datas = []): void {
    try {
        if(!file_exists($file_path.'.php')) throw new Exception('File introuvable');
        extract($datas);
        include $file_path.'.php';
    } catch (Exception $e) {
        include exception_path();
    }
}

function views_render($file_path, array $data = []):string {
    ob_start();
    include_file(views_path($file_path), $data);
    return ob_get_clean();
}
