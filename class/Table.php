<?php
use Connection\Connection;

class Table {
    protected $bdd;

    public function __construct(Connection $bdd) {
        $this -> bdd = $bdd;
    }

    //Déplacer des documents
    public function move_file($key, $path, $fileRemove = null) {
        if (!isset($_FILES[$key]) || $_FILES[$key]['error'] == UPLOAD_ERR_NO_FILE) {
            return $fileRemove;
        }

        if ($fileRemove != "" && file_exists(__DIR__ . '/../' . $path . $fileRemove)) {
            unlink(__DIR__ . '/..' . $path . $fileRemove);
        }

        $file = uniqid() . '.' . strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));
        move_uploaded_file($_FILES[$key]['tmp_name'], __DIR__ . '/../' . $path . $file);

        return $file;
    }
}