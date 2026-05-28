<?php

class ReviewService {
    public function __construct(
        private ReviewRepository $reviewRepository,
        private GiftRepository $giftRepository,
    ) {}

    public function listByGift(int $giftId, int $page, int $limit): array {
        $offset = ($page - 1) * $limit;
        $reviews = $this->reviewRepository->findAllByGiftId($giftId, $limit, $offset);
        return [
            'reviews'       => array_map(fn(Review $r) => $this->toDTO($r), $reviews),
            'reviews_count' => $this->reviewRepository->countByGiftId($giftId),
        ];
    }

    public function create(int $userId, int $giftId, PostReviewRequestDTO $dto): ReviewDTO {
        $this->giftRepository->findById($giftId);

        if ($this->reviewRepository->existsByUserAndGift($userId, $giftId)) {
            throw new ConflictException(['review' => ['You already reviewed this gift']]);
        }

        $review = new Review();
        $review->setUserId($userId);
        $review->setGiftId($giftId);
        $review->setRating((float) $dto->rating);
        $review->setComment($dto->comment);

        $review = $this->reviewRepository->create($review);
        $this->giftRepository->refreshScore($giftId);
        $full = $this->reviewRepository->findById($review->getId());

        return $this->toDTO($full);
    }

    public function update(int $reviewId, int $userId, PostReviewRequestDTO $dto): ReviewDTO {
        $review = $this->reviewRepository->findById($reviewId);
        if ($review === null) {
            throw new NotFoundException("Review not found");
        }
        if ($review->getUserId() !== $userId) {
            throw new NotFoundException("Review not found");
        }

        $review->setRating((float) $dto->rating);
        $review->setComment($dto->comment);
        $this->reviewRepository->update($review);
        $this->giftRepository->refreshScore($review->getGiftId());

        return $this->toDTO($review);
    }

    public function delete(int $reviewId, int $userId, string $userRole): void {
        $review = $this->reviewRepository->findById($reviewId);
        if ($review === null) {
            throw new NotFoundException("Review not found");
        }
        if ($review->getUserId() !== $userId && $userRole !== 'admin') {
            throw new NotFoundException("Review not found");
        }
        $this->reviewRepository->delete($reviewId);
        $this->giftRepository->refreshScore($review->getGiftId());
    }

    private function toDTO(Review $r): ReviewDTO {
        return new ReviewDTO(
            $r->getId(),
            $r->getUsername(),
            $r->getRating(),
            $r->getComment(),
            $r->getCreatedAt(),
        );
    }
}
