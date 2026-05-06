<?php
class User {
    private int $id;
    private string $username;
    private string $email;
    private string $password_hash;
    private string $user_role;
    private ?string $preferences_json;
    private string $created_at;

    public function getUsername(): string {
        return $this->username;
    }
    public function setUsername(string $username) {
        $this->username = $username;
    }
    public function getEmail(): string {
        return $this->email;
    }
    public function setEmail(string $email) {
        $this->email = $email;
    }
    public function getPasswordHash(): string {
        return $this->password_hash;
    }
    public function setPasswordHash(string $password_hash) {
        $this->password_hash = $password_hash;
    }
    public function getPreferencesJson(): string {
        return $this->preferences_json;
    }
    public function setPreferencesJson(string $preferences_json) {
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
        return $this->user_role;
    }
    public function setUserRole(string $user_role) {
        /*$res = match($user_role) {
            'user' => UserRole::user,
            'admin' => UserRole::admin,
            default => UserRole::user
        };*/
        $this->user_role = $user_role;
    }
}