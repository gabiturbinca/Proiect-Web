<?php

class Container {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance()->getConnection();
    }

    public function get(string $class) :object {
        return match($class) {
            GiftController::class => new GiftController(new GiftService(new GiftRepository($this->pdo))),
            CategoryController::class => new CategoryController(new CategoryService(new CategoryRepository($this->pdo))),
            default => throw new Exception("Class $class not found in container")
        };
    }
}