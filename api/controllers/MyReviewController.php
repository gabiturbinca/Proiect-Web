<?php

class MyReviewController {
    public function __construct(
        private ReviewService $reviewService,
        private CurrentUserDTO $current,
    ) {}

    public function create(int $giftId): ReviewDTO {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $data = Validator::make($input, PostReviewRequestDTO::RULES)->validate();
        $dto = new PostReviewRequestDTO(
            rating:  (float) $data['rating'],
            comment: $data['comment'] ?? null,
        );
        return $this->reviewService->create($this->current->id, $giftId, $dto);
    }

    public function update(int $reviewId): ReviewDTO {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $data = Validator::make($input, PostReviewRequestDTO::RULES)->validate();
        $dto = new PostReviewRequestDTO(
            rating:  (float) $data['rating'],
            comment: $data['comment'] ?? null,
        );
        return $this->reviewService->update($reviewId, $this->current->id, $dto);
    }

    public function delete(int $reviewId): array {
        $this->reviewService->delete($reviewId, $this->current->id, $this->current->role);
        return ['message' => 'Review deleted'];
    }
}
