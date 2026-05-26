<?php


final readonly class DummyJsonProductDTO {

    public function __construct(
        public int $externalId,
        public string $title,
        public ?string $description,
        public float $price,
        public ?string  $brand,
        public ?string  $category,
        public string  $thumbnail
    ) {}

    public static function toDTO(array $data): DummyJsonProductDTO {
        return new DummyJsonProductDTO(
        externalId: $data["id"],
        title: $data["title"] ?? '',
        description: $data["description"] ?? null,
        price: (float)($data["price"] ?? 999999),
        brand: $data["brand"] ?? null,
        category: $data["category"] ?? null,
        thumbnail: $data["thumbnail"] ?? ''
        );
    }
}