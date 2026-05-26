<?php

final readonly class RecommendationRequestDTO {
    public function __construct(
        public array   $categoryIds,
        public array   $brandIds,
        public ?int   $circumstanceId,
        public ?int   $contextId,
        public ?float $budgetMin,
        public ?float $budgetMax,
        public array  $tagIds,   
        public int    $limit,
        public int    $page,
    ) {}
}
