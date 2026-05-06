<?php

class BrandService {

    private BrandRepository $brandRepository;

    public function __construct(BrandRepository $brandRepository) {
        $this->brandRepository = $brandRepository;
    }
    public function getAllBrands() {
        return array_map(fn(Brand $b)=> new BrandDTO($b->getId(), $b->getName()),$this->brandRepository->findAll());
    }
}