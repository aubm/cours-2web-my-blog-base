<?php

spl_autoload_register(function($class_name) {
    $class_file_path = __DIR__ . '/src/' . str_replace('\\', '/', $class_name) . '.php';
    require_once($class_file_path);
});
