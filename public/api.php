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
$container->factory(PDO::class, fn() => Database::getInstance()->getConnection());
$container->factory(JwtService::class, fn() => new JwtService($_ENV['JWT_SECRET']));
$container->factory(ImageStorage::class, fn() => new ImageStorage(
    diskPath:   __DIR__ . '/uploads/gifts',
    publicPath: '/uploads/gifts',
));
$container->factory(UnsplashService::class, fn() => new UnsplashService(
    apiKey: $_ENV['UNSPLASH_ACCESS_KEY'] ?? '',
    cacheFile: __DIR__ . '/../db/logs/unsplash_cache.json',
));

$container->instance(Container::class, $container);
$router = new Router($container);

require_once __DIR__ . '/../api/routes.php';

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];
try {
    $result = $router->dispatch($method, $uri);
    if($result instanceof RawResponse)
        $result->send();
    else
        Response::success($result);
} catch (Throwable $e) {
    ExceptionHandler::handleException($e);
}
