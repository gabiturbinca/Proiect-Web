<?php

spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../api/controllers/',
        __DIR__ . '/../api/services/',
        __DIR__ . '/../api/repositories/',
        __DIR__ . '/../api/dtos/',
        __DIR__ . '/../api/models/',
        __DIR__ . '/../config/',
        __DIR__ . '/../utils/',
        __DIR__ . '/../utils/exceptions/',
    ];
    foreach ($paths as $path) {
        $file = $path . $class. '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});