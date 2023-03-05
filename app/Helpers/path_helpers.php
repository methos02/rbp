<?php

function database_path($file = ""): string {
    return getcwd()."\\database\\".$file;
}

function views_path($file = ""): string {
    return getcwd()."\\ressources\\views\\".$file;
}

function includes_path($file = ""): string {
    return getcwd()."\\includes\\".$file;
}
