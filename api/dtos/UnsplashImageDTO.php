<?php



final readonly class UnsplashImageDTO {
    public function __construct(
        public ?string $id,
        public ?string $urlFull,
        public ?string $urlThumb,
        public ?string $description,
        public ?string $authorName,
        public ?string $authorUrl,
    ) {}

    public function toArray(): array {
        return [
            'id'          => $this->id,
            'urlThumb'    => $this->urlThumb,
            'urlFull'     => $this->urlFull,
            'description' => $this->description,
            'authorName'  => $this->authorName,
            'authorUrl'   => $this->authorUrl,
        ];
    }
}