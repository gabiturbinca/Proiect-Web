<?php

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if ($path !== '/') {
    $publicDir = realpath(__DIR__);
    $resolved = realpath(__DIR__ . $path);
    if ($resolved !== false
        && str_starts_with($resolved, $publicDir . DIRECTORY_SEPARATOR)
        && is_file($resolved)) {
        return false;
    }
}

if (str_starts_with($path, '/api/')) {
    require __DIR__ . '/api.php';
    return;
}

require __DIR__ . '/home.php';
