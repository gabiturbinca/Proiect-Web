<?php

class ReviewController {
    public function __construct(private ReviewService $reviewService) {}

    public function index(int $giftId): array {
        $pageNumber = max(1, (int) ($_GET['pageNumber'] ?? 1));
        $elemNumber = max(1, min(100, (int) ($_GET['elemNumber'] ?? 10)));
        return $this->reviewService->listByGift($giftId, $pageNumber, $elemNumber);
    }
}
