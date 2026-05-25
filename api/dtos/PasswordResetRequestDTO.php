<?php

final readonly class PasswordResetRequestDTO {
    public function __construct(
        public int     $id,
        public int     $userId,
        public string  $username,
        public string  $status,
        public string  $requestedAt,
        public ?string $processedAt,
        public ?string $message,
    ) {}
}
