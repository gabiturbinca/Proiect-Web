<?php

readonly class IdNameDescImgCategoryDTO {
    public function __construct(
        public int $id,
        public string $name,
        public ?string $image_url,
        public ?string $description
    ) {}
}
