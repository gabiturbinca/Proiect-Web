<?php

class ExceptionHandler {
    public static function handleException(Throwable $e) {
        
        header('Content-Type: application/json');
        if($e instanceof ValidationException) {
            http_response_code(422);
            echo json_encode([
                'error'=> [
                    'message' =>$e->getMessage(),
                    'errors' => $e->getErrors(),
                ]
            ]);
            return;
        }

        if($e instanceof NotFoundException) {
            http_response_code(404);
             echo json_encode([
                'error'=> [
                    'message' => $e->getMessage(),
                ]
            ]);
            return;
        }

        http_response_code(500);

        $payload = ['message' => 'Internal server error'];
        if (($_ENV['APP_ENV'] ?? 'production') === 'development') {
        $payload['debug'] = [
                            'message' => $e->getMessage(),
                            'file' => $e->getFile(),
                            'line' =>$e->getLine(),
                            'trace' => $e->getTrace(),
                            ];
        }
        echo json_encode(['error' => $payload]);
    }
    public static function errorHandler($errno, $errstr, $errfile, $errline) {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
}