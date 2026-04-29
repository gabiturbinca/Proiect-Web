<?php

class ExceptionHandler {
    public static function handleException(Throwable $e) {
        http_response_code(500);
        header('Content-Type: application/json');
        $response = [ 'error' => 'An error occurred.'];

        if ($_ENV['APP_ENV'] === 'development') {
            $response['message'] = $e->getMessage();
            $response['file'] = $e->getFile();
            $response['line'] = $e->getLine();
            $response['trace'] = $e->getTraceAsString();
        }
        echo json_encode($response);
    }
    public static function errorHandler($errno, $errstr, $errfile, $errline) {
        throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
    }
}