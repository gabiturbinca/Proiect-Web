<?php

final readonly class UpdateGiftRequestDTO {
    public const RULES = [
        'name'            => ['min:1', 'max:255'],
        'description'     => ['max:2000'],
        'price'           => ['numeric_min:0', 'numeric_max:999999'],
        'category_id'     => ['numeric_id'],
        'brand_id'        => ['numeric_id'],
        'specifications'  => [],
        'tags'            => [],
        'circumstances'   => [],
        'contexts'        => [],
    ];

    public function __construct(
        public ?string $name,
        public ?string $description,
        public ?float  $price,
        public ?int    $categoryId,
        public ?int    $brandId,
        public ?array  $specifications,
        public ?array  $tagIds,
        public ?array  $circumstanceIds,
        public ?array  $contextIds,
    ) {}
}
