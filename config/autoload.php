<?php
require_once __DIR__ . '/../vendor/autoload.php';
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../api/controllers/',
        __DIR__ . '/../api/services/',
        __DIR__ . '/../api/repositories/',
        __DIR__ . '/../api/dtos/',
        __DIR__ . '/../api/models/',
        __DIR__ . '/../api/middleware/',
        __DIR__ . '/../api/services/scoring/',
        __DIR__ . '/../api/services/reports/',
        __DIR__ . '/../config/',
        __DIR__ . '/../utils/',
        __DIR__ . '/../utils/exceptions/',
        __DIR__ . '/../utils/validation/',         
        __DIR__ . '/../utils/validation/rules/', 
    ];
    foreach ($paths as $path) {
        $file = $path . $class. '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});