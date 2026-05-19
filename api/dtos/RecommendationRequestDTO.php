<?php

final readonly class RecommendationRequestDTO {
    public function __construct(
        public ?int   $categoryId,
        public ?int   $brandId,
        public ?int   $circumstanceId,
        public ?int   $contextId,
        public ?float $budgetMin,
        public ?float $budgetMax,
        public array  $tagIds,   
        public int    $limit,
        public int    $page,
    ) {}
}
