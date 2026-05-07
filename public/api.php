<?php

require_once __DIR__ . '/../config/env.php';
loadEnv(__DIR__ . '/../.env');
session_set_cookie_params([
    'lifetime' => 0,             
    'path'     => '/',
    'domain'   => '',                   
    'secure'   => ($_ENV['APP_ENV'] ?? 'production') === 'production',                
    'httponly' => true,                 
    'samesite' => 'Lax',                
]);
session_start();
require_once __DIR__ . '/../config/ExceptionHandler.php';
set_exception_handler([ExceptionHandler::class, 'handleException']);
set_error_handler([ExceptionHandler::class, 'errorHandler']);

require_once __DIR__ . '/../utils/helpers.php';
require_once __DIR__ . '/../config/autoload.php';
require_once __DIR__ . '/../api/Router.php';
require_once __DIR__ . '/../config/Container.php';

$container = new Container();
$container->factory(PDO::class, fn() => Database::getInstance()->getConnection());
$router = new Router($container);

require_once __DIR__ . '/../api/routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
try {
    $result = $router->dispatch($method, $uri);
    Response::success($result);
} catch (Throwable $e) {
    ExceptionHandler::handleException($e);
}
