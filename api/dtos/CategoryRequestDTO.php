<?php

final readonly class CategoryRequestDTO {
    public const RULES_CREATE = [
        'name'        => ['required', 'min:1', 'max:255'],
        'description' => ['max:2000'],
        'image_url'   => ['max:500'],
        'is_active'   => [],
        'sort_order'  => ['numeric_min:0'],
    ];

    public const RULES_UPDATE = [
        'name'        => ['min:1', 'max:255'],
        'description' => ['max:2000'],
        'image_url'   => ['max:500'],
        'is_active'   => [],
        'sort_order'  => ['numeric_min:0'],
    ];

    public function __construct(
        public ?string $name,
        public ?string $description,
        public ?string $imageUrl,
        public ?bool   $isActive,
        public ?int    $sortOrder,
    ) {}
}
