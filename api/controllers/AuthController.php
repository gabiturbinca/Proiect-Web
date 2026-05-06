<?php

class AuthController {

    private AuthService $authService;
    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }
    public function register() {
       $input = json_decode(file_get_contents("php://input"), true) ?? [];

       $data = Validator::make($input, RegisterRequestDTO::RULES)->validate();
       $req = new RegisterRequestDTO($data['username'], $data['email'], $data['password'], $data['password_confirmation']);
       return $this->authService->register($req->toRegisterUserDTO());
    }
}