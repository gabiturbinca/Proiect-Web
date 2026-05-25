<?php

final readonly class ReviewDTO {
    public function __construct(
        public int     $id,
        public string  $username,
        public float   $rating,
        public ?string $comment,
        public string  $created_at,
    ) {}
}
