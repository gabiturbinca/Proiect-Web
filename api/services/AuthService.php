<?php

class AuthService {

    private UserRepository $userRepository;

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
}