<?php

class UserService {
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository) {
        $this->userRepository = $userRepository;
    }
    public function getUserById($id) {
        $user = $this->userRepository->findById($id);
        return new UserDTO($user->getId(), $user->getUsername(), $user->getEmail(), $user->getUserRole());
    }
    public function getAll() {
        $users = $this->userRepository->findAll();
        $userDTOs = array_map(fn(User $user) => new UserDTO($user->getId(), $user->getUsername(), $user->getEmail(), $user->getUserRole()), $users);
        return $userDTOs;
    }
    
}