<?php

namespace App\Core\Rules;

use SplFileInfo;

/** @noinspection PhpUnused */
class
ImageRule extends BaseRule {
    private array $extensions = ['jpg', 'jpeg', 'bmp', 'png', 'webp'];
    public function check():bool {
        $file = new SplFileInfo($_FILES[$this->input_name]['name']);

        return !in_array($file->getExtension(), $this->extensions);
    }

    public function error():string {
        return "Le fichier doit être une image.";
    }
}
