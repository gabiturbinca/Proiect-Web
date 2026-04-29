<?php
//pt env
require_once __DIR__ . '/../config/env.php';
loadEnv(__DIR__ . '/../.env');


//pt exceptii
require_once __DIR__ . '/../config/ExceptionHandler.php';
set_exception_handler([ExceptionHandler::class, 'handleException']);
set_error_handler([ExceptionHandler::class,'errorHandler']);

//general clase
require_once __DIR__ . '/../config/Database.php';
require_once __DIR__ . '/../utils/Response.php';
require_once __DIR__ . '/../utils/helpers.php';
require_once __DIR__ . '/../utils/exceptions/NotFoundException.php';
require_once __DIR__ . '/../api/Router.php';
require_once __DIR__ . '/../api/repositories/GiftRepository.php';
require_once __DIR__ . '/../api/repositories/CategoryRepository.php';
require_once __DIR__ . '/../api/services/GiftService.php';
require_once __DIR__ . '/../api/services/CategoryService.php';
require_once __DIR__ . '/../api/controllers/GiftController.php';
require_once __DIR__ . '/../api/controllers/CategoryController.php';
require_once __DIR__ . '/../config/Container.php';
//pt router

$container = new Container();
$router = new Router($container);

require_once __DIR__ . '/../api/routes.php';
$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// 
try {
    $result = $router -> dispatch($method, $uri);
    Response::success($result);
}
catch (NotFoundException $e) {
    Response::error($e->getMessage(),404);
}
catch (Throwable $e) {
    ExceptionHandler::handleException($e);
}