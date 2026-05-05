<?php

class UserController {
    private UserService $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }
    public function index() : array {
        return $this->userService->getAll();
    }

    public function show($id) : UserDTO {
        return $this->userService->getUserById($id);
    }
}