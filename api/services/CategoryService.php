<?php

class CategoryService {
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories($activeOnly = true) {
        return $this->categoryRepository->findAll($activeOnly);
    }

    public function getCategoryById($id, $activeOnly = true) {
        return $this->categoryRepository->findById($id, $activeOnly);
    }
}