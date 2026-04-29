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
            TagController::class => new TagController(new TagService(new TagRepository($this->pdo))),
            BrandController::class => new BrandController(new BrandService(new BrandRepository($this->pdo))),
            FormController::class => new FormController(
                new BrandService(new BrandRepository($this->pdo)),
                new TagService(new TagRepository($this->pdo)),
                new CategoryService(new CategoryRepository($this->pdo))),
            default => throw new Exception("Class $class not found in container")
        };
    }
}