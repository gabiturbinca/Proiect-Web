<?php

readonly class TagDTO {
    public function __construct(
        public int $id,
        public string $name,
        public string $slug
        ) {}
}