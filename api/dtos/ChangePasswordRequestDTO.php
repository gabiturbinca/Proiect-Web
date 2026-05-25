<?php

final readonly class ChangePasswordRequestDTO {

    public function __construct(
        public string $newPassword,
        public string $oldPassword,
        public string $newPasswordConfirmation
    ) {}

    public const RULES = [
        'new_password' => ['required', 'min:8', 'max:100', 'confirmed'],
        'current_password' => ['required'],
        'new_password_confirmation' => ['required'],
    ];
}