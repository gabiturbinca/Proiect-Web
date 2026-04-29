<?php

class BrandService {

    private BrandRepository $brandRepository;

    public function __construct(BrandRepository $brandRepository) {
        $this->brandRepository = $brandRepository;
    }
    public function getAllBrands() {
        return $this->brandRepository->findAll();
    }
}