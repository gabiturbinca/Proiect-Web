<?php

final readonly class CurrentUserDTO {
    public function __construct(
        public int $id,
        public string $role,
    ) {}
}