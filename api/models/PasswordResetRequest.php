<?php

class PasswordResetRequest {
    private int $id;
    private int $user_id;
    private string $requested_at;
    private string $status;
    private ?int $admin_user_id;
    private ?string $processed_at;
    private ?string $message;

    private ?string $username = null;

    public function setId(int $id): void { $this->id = $id; }
    public function getId(): int { return $this->id; }

    public function setUserId(int $userId): void { $this->user_id = $userId; }
    public function getUserId(): int { return $this->user_id; }

    public function setRequestedAt(string $requestedAt): void { $this->requested_at = $requestedAt; }
    public function getRequestedAt(): string { return $this->requested_at; }

    public function setStatus(string $status): void { $this->status = $status; }
    public function getStatus(): string { return $this->status; }

    public function setAdminUserId(?int $adminUserId): void { $this->admin_user_id = $adminUserId; }
    public function getAdminUserId(): ?int { return $this->admin_user_id; }

    public function setProcessedAt(?string $processedAt): void { $this->processed_at = $processedAt; }
    public function getProcessedAt(): ?string { return $this->processed_at; }

    public function setMessage(?string $message): void { $this->message = $message; }
    public function getMessage(): ?string { return $this->message; }

    public function setUsername(?string $username): void { $this->username = $username; }
    public function getUsername(): ?string { return $this->username; }
}
