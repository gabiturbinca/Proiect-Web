<?php
function loadEnv($path) {
    //in prod variabilele vin din render, deci trebuie sa populez
    foreach (['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASS', 'APP_ENV', 'JWT_SECRET'] as $key) {
        $value = getenv($key);
        if ($value !== false && !isset($_ENV[$key])) {
            $_ENV[$key] = $value;
        }
    }

    // daca sunt dev si am .env local dau override
    if (!file_exists($path)) {
        return;
    }

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with($line, '#')) continue;
        if (!str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}
?>
