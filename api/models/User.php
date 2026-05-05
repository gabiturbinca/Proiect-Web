<?php
class User {
    private int $id;
    private string $username;
    private string $email;
    private string $password;
    private UserRole $user_role;
    private array $preferences_json;
    private string $created_at;

    public function getUserame(): string {
        return $this->username;
    }
    public function setUserame(string $username) {
        $this->username = $username;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function setEmail(string $email) {
        $this->email = $email;
    }
    public function getPassword(): string {
        return $this->password;
    }
    public function setPassword(string $password) {
        $this->password = $password;
    }
    public function getPreferencesJson(): array {
        return $this->preferences_json;
    }
    public function setPreferencesJson(array $preferences_json) {
        $this->preferences_json = $preferences_json;
    }
    public function getCreatedAt(): string {
        return $this->created_at;
    }
    public function setCreatedAt(string $created_at) {
        $this->created_at = $created_at;
    }
    public function getId(): int {
        return $this->id;
    }
    public function setId(int $id) {
        $this->id = $id;
    }
    public function getUserRole(): string {
        return $this->username;
    }
    public function setUserRole(UserRole $user_role) {
        $this->user_role = $user_role;
    }
}