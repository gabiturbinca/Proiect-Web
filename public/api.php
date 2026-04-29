<?php

require_once __DIR__ . '/../config/env.php';
loadEnv(__DIR__ . '/../.env');

require_once __DIR__ . '/../config/ExceptionHandler.php';
set_exception_handler([ExceptionHandler::class, 'handleException']);
set_error_handler([ExceptionHandler::class, 'errorHandler']);

require_once __DIR__ . '/../utils/helpers.php';
require_once __DIR__ . '/../config/autoload.php';
require_once __DIR__ . '/../api/Router.php';
require_once __DIR__ . '/../config/Container.php';

$container = new Container();
$router = new Router($container);

require_once __DIR__ . '/../api/routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

try {
    $result = $router->dispatch($method, $uri);
    Response::success($result);
} catch (NotFoundException $e) {
    Response::error($e->getMessage(), 404);
} catch (Throwable $e) {
    ExceptionHandler::handleException($e);
}
