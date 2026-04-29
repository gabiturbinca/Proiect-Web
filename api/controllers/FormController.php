<?php

class FormController {
    private BrandService $brand_service;
    private TagService $tag_service;
    private CategoryService $category_service;

    public function __construct(
        BrandService $brand_service,
        TagService $tag_service,
        CategoryService $categoryService
        ) {
        $this->brand_service = $brand_service;
        $this->tag_service = $tag_service;
        $this->category_service = $categoryService;
    }

    public function index() : array {
        $categories = $this->category_service->getIdNameCategories();
        $brands = $this->brand_service->getAllBrands();
        $tags = $this->tag_service->getAllTags();
        return [
            "categories"=> $categories,
            "brands"=> $brands,
            "tags"=> $tags
        ];
    }
}