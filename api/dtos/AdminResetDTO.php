<?php

final readonly class AdminResetDTO {

    public function __construct(
        public int $userId,
        public string $tempPassword
    ) {}
}