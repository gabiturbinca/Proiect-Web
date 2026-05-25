<?php

class PasswordResetRequestRepository {
    public function __construct(private PDO $db) {}

    private function hydrate(array $row): PasswordResetRequest {
        $r = new PasswordResetRequest();
        $r->setId((int) $row['id']);
        $r->setUserId((int) $row['user_id']);
        $r->setRequestedAt($row['requested_at']);
        $r->setStatus($row['status']);
        $r->setAdminUserId($row['admin_user_id'] !== null ? (int) $row['admin_user_id'] : null);
        $r->setProcessedAt($row['processed_at']);
        $r->setMessage($row['message']);
        $r->setUsername($row['username'] ?? null);
        return $r;
    }

    public function create(int $userId, ?string $message): int {
        $stmt = $this->db->prepare(
            "INSERT INTO password_reset_requests (user_id, message)
             VALUES (?, ?)
             RETURNING id"
        );
        $stmt->execute([$userId, $message]);
        return (int) $stmt->fetchColumn();
    }

    public function findById(int $id): ?PasswordResetRequest {
        $stmt = $this->db->prepare(
            "SELECT r.*, u.username
             FROM password_reset_requests r
             JOIN users u ON r.user_id = u.id
             WHERE r.id = ?"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }

    public function findPending(int $limit, int $offset): array {
        $stmt = $this->db->prepare(
            "SELECT r.*, u.username
             FROM password_reset_requests r
             JOIN users u ON r.user_id = u.id
             WHERE r.status = 'pending'
             ORDER BY r.requested_at ASC
             LIMIT ? OFFSET ?"
        );
        $stmt->execute([$limit, $offset]);
        return array_map($this->hydrate(...), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function countPending(): int {
        $stmt = $this->db->query("SELECT COUNT(1) FROM password_reset_requests WHERE status = 'pending'");
        return (int) $stmt->fetchColumn();
    }

    public function markApproved(int $requestId, int $adminId): void {
        $stmt = $this->db->prepare(
            "UPDATE password_reset_requests
             SET status = 'accepted', admin_user_id = ?, processed_at = NOW()
             WHERE id = ?"
        );
        $stmt->execute([$adminId, $requestId]);
    }

    public function markDenied(int $requestId, int $adminId): void {
        $stmt = $this->db->prepare(
            "UPDATE password_reset_requests
             SET status = 'denied', admin_user_id = ?, processed_at = NOW()
             WHERE id = ?"
        );
        $stmt->execute([$adminId, $requestId]);
    }
}
