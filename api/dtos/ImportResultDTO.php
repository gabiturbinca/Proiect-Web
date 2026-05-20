<?php


final readonly class ImportResultDTO {
    public function __construct(
        public int $total,
        public int $imported,
        public int $failed,
        public array $errors,
    ) {}
}