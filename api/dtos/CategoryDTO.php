<?php

readonly class CategoryDTO {
    public function __construct(
        public int $id,
        public string $name,
        public string $description,
        public string $image_url,
    ) {}
}