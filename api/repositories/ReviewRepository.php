<?php

class ReviewRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function hydrate(array $row): Review {
        $r = new Review();
        $r->setId((int) $row["id"]);
        $r->setGiftId((int) $row["gift_id"]);
        $r->setUserId((int) $row["user_id"]);
        $r->setRating((float) $row["rating"]);
        $r->setComment($row["comment"]);
        $r->setCreatedAt($row["created_at"]);
        $r->setUsername($row["username"] ?? '');
        $r->setGiftName($row["gift_name"] ?? '');
        return $r;
    }

    public function findById(int $id): ?Review {
        $stmt = $this->db->prepare(
            "SELECT r.id, r.gift_id, r.user_id, r.rating, r.comment, r.created_at,
                    u.username, g.name AS gift_name
             FROM reviews r
             JOIN users u ON r.user_id = u.id
             JOIN gifts g ON r.gift_id = g.id
             WHERE r.id = ?"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }

    public function findAllByGiftId(int $giftId): array {
        $stmt = $this->db->prepare(
            "SELECT r.id, r.gift_id, r.user_id, r.rating, r.comment, r.created_at,
                    u.username, g.name AS gift_name
             FROM reviews r
             JOIN users u ON r.user_id = u.id
             JOIN gifts g ON r.gift_id = g.id
             WHERE r.gift_id = ?
             ORDER BY r.created_at DESC"
        );
        $stmt->execute([$giftId]);
        return array_map($this->hydrate(...), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findAllByUserId(int $userId): array {
        $stmt = $this->db->prepare(
            "SELECT r.id, r.gift_id, r.user_id, r.rating, r.comment, r.created_at,
                    u.username, g.name AS gift_name
             FROM reviews r
             JOIN users u ON r.user_id = u.id
             JOIN gifts g ON r.gift_id = g.id
             WHERE r.user_id = ?
             ORDER BY r.created_at DESC"
        );
        $stmt->execute([$userId]);
        return array_map($this->hydrate(...), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function existsByUserAndGift(int $userId, int $giftId): bool {
        $stmt = $this->db->prepare(
            "SELECT 1 FROM reviews WHERE user_id = ? AND gift_id = ?"
        );
        $stmt->execute([$userId, $giftId]);
        return (bool) $stmt->fetchColumn();
    }

    public function create(Review $review): Review {
        $stmt = $this->db->prepare(
            "INSERT INTO reviews (gift_id, user_id, rating, comment)
             VALUES (?, ?, ?, ?)
             RETURNING id, created_at"
        );
        $stmt->execute([
            $review->getGiftId(),
            $review->getUserId(),
            $review->getRating(),
            $review->getComment(),
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $review->setId((int) $row["id"]);
        $review->setCreatedAt($row["created_at"]);
        return $review;
    }

    public function update(Review $review): Review {
        $stmt = $this->db->prepare(
            "UPDATE reviews SET rating = ?, comment = ? WHERE id = ?"
        );
        $stmt->execute([
            $review->getRating(),
            $review->getComment(),
            $review->getId(),
        ]);
        return $review;
    }

    public function delete(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM reviews WHERE id = ?");
        $stmt->execute([$id]);
    }
}
