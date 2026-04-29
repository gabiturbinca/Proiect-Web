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

    public function getShortCategories($activeOnly = true) {
        return $this->categoryRepository->findShortCategories($activeOnly);
    }

    public function getIdNameCategories($activeOnly = true) {
        return $this->categoryRepository->findIdNameCategories($activeOnly);
    }
}