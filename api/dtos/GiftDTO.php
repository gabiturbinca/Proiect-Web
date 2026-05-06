<?php

readonly class GiftDTO {
    public function __construct(
        public int $id,
        public string $name,
        public ?string $description,
        public float $price,
        public ?string $image_url,
        public ?string $brand_name,
        public ?string $category_name
    ) {}

}