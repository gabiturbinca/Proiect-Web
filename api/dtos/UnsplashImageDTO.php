<?php



final readonly class UnsplashImageDTO {
    public function __construct(
        public int $id,
        public ?string $urlFull,
        public ?string $urlThumb,
        public ?string $description,
        public ?string $authorName,
        public ?string $authorUrl,
    ) {}
}