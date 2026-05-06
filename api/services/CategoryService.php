<?php

class CategoryService {
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories($activeOnly = true) {
        return array_map(fn(Category $c) => new CategoryDTO($c->getId(), $c->getName(), $c->getDescription(), $c->getImageUrl()),$this->categoryRepository->findAll($activeOnly));
    }

    public function getCategoryById($id, $activeOnly = true) {
        $category = $this->categoryRepository->findById($id);
        return new CategoryDTO($category->getId(), $category->getName(), $category->getDescription(), $category->getImageUrl());
    }
    public function getIdNameCategories($activeOnly = true) {
        return array_map(fn(Category $c) => new IdNameCategoryDTO($c->getId(), $c->getName()),$this->categoryRepository->findAll($activeOnly));
    }
}