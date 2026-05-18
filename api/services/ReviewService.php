<?php

class ReviewService {
    public function __construct(
        private ReviewRepository $reviewRepository,
        private GiftRepository $giftRepository,
    ) {}

    public function listByGift(int $giftId): array {
        $reviews = $this->reviewRepository->findAllByGiftId($giftId);
        return array_map(
            fn(Review $r) => new ReviewDTO(
                $r->getId(),
                $r->getUsername(),
                $r->getRating(),
                $r->getComment(),
                $r->getCreatedAt(),
            ),
            $reviews,
        );
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
        $full = $this->reviewRepository->findById($review->getId());

        return new ReviewDTO(
            $full->getId(),
            $full->getUsername(),
            $full->getRating(),
            $full->getComment(),
            $full->getCreatedAt(),
        );
    }

    public function update(int $reviewId, int $userId, PostReviewRequestDTO $dto): ReviewDTO {
        $review = $this->reviewRepository->findById($reviewId);
        if ($review === null) {
            throw new NotFoundException("Review not found");
        }
        if ($review->getUserId() !== $userId) {
            throw new AuthException("You can only edit your own reviews");
        }

        $review->setRating((float) $dto->rating);
        $review->setComment($dto->comment);
        $this->reviewRepository->update($review);

        return new ReviewDTO(
            $review->getId(),
            $review->getUsername(),
            $review->getRating(),
            $review->getComment(),
            $review->getCreatedAt(),
        );
    }

    public function delete(int $reviewId, int $userId, string $userRole): void {
        $review = $this->reviewRepository->findById($reviewId);
        if ($review === null) {
            throw new NotFoundException("Review not found");
        }
        if ($review->getUserId() !== $userId && $userRole !== 'admin') {
            throw new AuthException("You can only delete your own reviews");
        }
        $this->reviewRepository->delete($reviewId);
    }
}
