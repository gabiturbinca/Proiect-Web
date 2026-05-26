<?php

class AuthService {
    private const HASH_FAKE = '$2y$10$0mIR/tc5l1qOVq4PUf28.uLWJabiK.vTPNT.rFnc6VYYG7XdAjdh6';
    public function __construct(
        private UserRepository $userRepository,
        private JwtService $jwtService,
        private PasswordResetRequestRepository $resetRequestRepository,
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
            'username' => $user->getUsername(),
        ]);
        CsrfService::putCookie(CsrfService::generateToken());
        return [
            'token' => $token,
            'user' => new UserDTO(
                $user->getId(),
                $user->getUsername(),
                $user->getEmail(),
                $user->getUserRole(),
            ),
            'must_change_password' => $user->getMustChangePassword(),
        ];
    }

    public function changePassword(int $userId, ChangePasswordRequestDTO $dto) : array {
        $user = $this->userRepository->findById($userId);
        if(! password_verify($dto->oldPassword, $user->getPasswordHash())) {
            throw new AuthException("Incorrect current pasword");
        }
        // if(!password_verify($dto->newPassword,$user->getPasswordHash())) {
        //     throw new ValidationException(['new_password' => ['New password must differ from current']]);
        // }
        // vedem daca poate la fel sau nu

        $newHash = password_hash($dto->newPassword, PASSWORD_BCRYPT);
        $this->userRepository->updatePassword($userId, $newHash);
        $this->userRepository->setMustChangePassword($userId, false);
        $token = $this->jwtService->encode([
            'sub' => $user->getId(),
            'role' => $user->getUserRole(),
            'username' => $user->getUsername(),
        ]);
        CsrfService::putCookie(CsrfService::generateToken());
        return [
            'token'=> $token,
        ];
    }

    public function registerResetRequest(ResetAsUnkownDTO $dto): void {
        $user = filter_var($dto->identifier, FILTER_VALIDATE_EMAIL)
            ? $this->userRepository->findByEmail($dto->identifier)
            : $this->userRepository->findByUsername($dto->identifier);
        if ($user !== null) {
            $this->resetRequestRepository->create($user->getId(), $dto->message);
        }
    }
}