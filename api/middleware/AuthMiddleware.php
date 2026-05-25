<?php

class AuthMiddleware implements Middleware {
    public function __construct(
        private JwtService $jwtService,
        private Container $container,
        private UserRepository $userRepository
    )
    {}

    #[Override]
    public function handle(): void {
        $token = $_COOKIE['auth_token'] ?? null;
        if($token === null) {
            throw new AuthException("Auth required");
        }
        $payload = $this->jwtService->decode($token);
        if (!isset($payload['sub']) || !isset($payload['role']))
            throw new AuthException("Invalid token payload");
        $user = $this->userRepository->findById($payload['sub']);
        if ((int) $payload['iat'] < $user->getPasswordChangedAt()) {
            throw new AuthException("Session invalidated due to password change");
        }

        $this->container->instance(CurrentUserDTO::class, new CurrentUserDTO(
            id:(int) $payload['sub'],
            role:(string) $payload['role'],
        ));
    }
}