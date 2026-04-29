<?php

class BrandController {
    private BrandService $brandService;

    public function __construct(BrandService $brandService) {
        $this->brandService = $brandService;
    }

    public function index() : array {
        return $this->brandService->getAllBrands();
    }
}