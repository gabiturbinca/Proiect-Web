<?php

class Response {
    public static function json($data, $statusCode = 200): void {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
    }

    public static function error($data, $statusCode = 400): void {
        self::json(['error' => $data], $statusCode);
    }

    public static function success($data, $statusCode = 200): void {
        self::json(['success' => $data], $statusCode);
    }
}