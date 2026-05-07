<?php

class AuthService {

    private UserRepository $userRepository;
    private const HASH_FAKE = '$2y$10$0mIR/tc5l1qOVq4PUf28.uLWJabiK.vTPNT.rFnc6VYYG7XdAjdh6';
    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }
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

    public function login(LoginRequestDTO $dto) : UserDTO {

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
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_role'] = $user->getUserRole();
        return new UserDTO($user->getId(), $user->getUsername(), $user->getEmail(), $user->getUserRole() );

    }
}