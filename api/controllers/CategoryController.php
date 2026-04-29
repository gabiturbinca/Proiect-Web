<?php

class CategoryController {
    private CategoryService $categoryService;
    public function __construct(CategoryService $categoryService) {
        $this->categoryService = $categoryService;
    }

    public function index() : array {
        $activeOnly = isset($_GET['activeOnly']) ? filter_var($_GET['activeOnly'], FILTER_VALIDATE_BOOLEAN) : true;
        return $this->categoryService->getAllCategories($activeOnly);
    }

    public function show($id) : array {
        return $this->categoryService->getCategoryById($id);
    }

    public function indexShort() : array {
        $activeOnly = isset($_GET['activeOnly']) ? filter_var($_GET['activeOnly'], FILTER_VALIDATE_BOOLEAN) : true;
        return $this->categoryService->getShortCategories($activeOnly);
    }
}