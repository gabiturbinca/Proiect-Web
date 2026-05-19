<?php

class AuthController {

    public function __construct(private AuthService $authService,
                                private Container $container) {}
    public function register() :UserDTO {
       $input = json_decode(file_get_contents("php://input"), true) ?? [];

       $data = Validator::make($input, RegisterRequestDTO::RULES)->validate();
       $req = new RegisterRequestDTO($data['username'], $data['email'], $data['password'], $data['password_confirmation']);
       return $this->authService->register($req->toRegisterUserDTO());
    }

    public function login() :UserDTO {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $data = Validator::make($input, LoginRequestDTO::RULES)->validate();
        $req = new LoginRequestDTO($data['identifier'], $data['password']);
        $result = $this->authService->login($req);
        setcookie('auth_token', $result['token'], [
            'expires' =>time() + 3600,
            'path' => '/',
            'secure' => ($_ENV['APP_ENV'] ?? 'production') === 'production',
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
        return $result['user'];
    }
    public function me(): CurrentUserDTO {
        $current = $this->container->get(CurrentUserDTO::class);
        return $current;
    }

    public function logout(): array {
        setcookie('auth_token', '', [
            'expires'  => time() - 3600,
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        setcookie('csrf_token', '', [
            'expires'  => time() - 3600,
            'path'     => '/',
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        return ['message' => 'Logged out'];
    }
}