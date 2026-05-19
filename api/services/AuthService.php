<?php

class AuthService {
    private const HASH_FAKE = '$2y$10$0mIR/tc5l1qOVq4PUf28.uLWJabiK.vTPNT.rFnc6VYYG7XdAjdh6';
    public function __construct(
        private UserRepository $userRepository,
        private JwtService $jwtService,
    ) {}
    public function register(RegisterUserDTO $dto) :UserDTO {
        $errors = [];
        if ($this->userRepository->existsByUsername($dto->username)) {
            $errors['username'] = ['Username already taken'];
        }
        if ($this->userRepository->existsByEmail($dto->email)) {
            $errors['email'] = ['Email already registered'];
        }
        if (!empty($errors)) {
            throw new ConflictException($errors);
        }
        $phash = password_hash($dto->password, PASSWORD_BCRYPT);
        $user = new User();
        $user->setEmail($dto->email);
        $user->setPasswordHash($phash);
        $user->setUsername($dto->username);
        $user = $this->userRepository->create($user);
        return new UserDTO($user->getId(), $user->getUsername(), $user->getEmail(), $user->getUserRole() );
    }

    public function login(LoginRequestDTO $dto) : array {

        if(filter_var($dto->identifier, FILTER_VALIDATE_EMAIL))
            $user = $this->userRepository->findByEmail($dto->identifier);
        else
            $user =$this->userRepository->findByUsername($dto->identifier);
        if ($user === null) {
            password_verify($dto->password, self::HASH_FAKE);
            throw new AuthException();
        }
        if(!password_verify($dto->password,$user->getPasswordHash())) {
            throw new AuthException();
        }
        $token = $this->jwtService->encode([
            'sub' => $user->getId(),
            'role' => $user->getUserRole(),
        ]);
        return [
            'token' => $token,
            'user' => new UserDTO(
                $user->getId(),
                $user->getUsername(),
                $user->getEmail(),
                $user->getUserRole(),
            ),
        ];

    }
}