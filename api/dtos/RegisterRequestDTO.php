<?php


readonly class RegisterRequestDTO {
    public const RULES = [
        'username' => ['required', 'min:3', 'max:100', 'alpha_num'],
        'email' => ['required', 'max:100', 'email'],
        'password'=> ['required', 'min:8', 'max:100', 'confirmed'],
        'password_confirmation' => ['required']
    ];
    public function __construct(
        public string $username,
        public string $email,
        public string $password,
        public string $password_confirmation,
    ) {}

    public function toRegisterUserDTO(): RegisterUserDTO {
        return new RegisterUserDTO($this->username, $this->email, $this->password);
    }
}