<?php

class ReviewController {
    public function __construct(
        private ReviewService $reviewService,
        private Container $container,
    ) {}

    public function index(int $giftId): array {
        return $this->reviewService->listByGift($giftId);
    }

    public function create(int $giftId): ReviewDTO {
        $current = $this->container->get(CurrentUserDTO::class);
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $data = Validator::make($input, PostReviewRequestDTO::RULES)->validate();
        $dto = new PostReviewRequestDTO(
            rating:  (float) $data['rating'],
            comment: $data['comment'] ?? null,
        );
        return $this->reviewService->create($current->id, $giftId, $dto);
    }

    public function update(int $reviewId): ReviewDTO {
        $current = $this->container->get(CurrentUserDTO::class);
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $data = Validator::make($input, PostReviewRequestDTO::RULES)->validate();
        $dto = new PostReviewRequestDTO(
            rating:  (int) $data['rating'],
            comment: $data['comment'] ?? null,
        );
        return $this->reviewService->update($reviewId, $current->id, $dto);
    }

    public function delete(int $reviewId): array {
        $current = $this->container->get(CurrentUserDTO::class);
        $this->reviewService->delete($reviewId, $current->id, $current->role);
        return ['message' => 'Review deleted'];
    }
}
