<?php

final readonly class PostReviewRequestDTO {
    public const RULES = [
        'rating'  => ['required', 'numeric_min:1', 'numeric_max:5'],
        'comment' => ['max:1000'],
    ];

    public function __construct(
        public float    $rating,
        public ?string $comment,
    ) {}
}
