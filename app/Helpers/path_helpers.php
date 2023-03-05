<?php

function database_path($file = ""): string {
    return getcwd()."\\database\\".$file;
}
