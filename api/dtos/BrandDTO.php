<?php

readonly class BrandDTO {
    public function __construct(
        public int $id,
        public string $name
    ) {}
}