<?php


final readonly class ContextDTO {
    public function __construct(
        public int $id,
        public string $name
    ) {}
}