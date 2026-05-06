<?php

readonly class UserDTO {
    public function __construct(
        public int $id,
        public string $username,
        public string $email,
        public UserRole $user_role
    ) {}
    
}