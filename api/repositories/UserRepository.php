<?php

class UserRepository {

    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function hydrate (array $row) : ?User{
        if(!$row) {
            return null;
        }
        $user = new User();
        $user->setUsername($row["username"]);
        $user->setEmail($row["email"]);
        $user->setPasswordHash($row["password_hash"]);
        $user->setUserRole($row["role"]);
        $user->setPreferencesJson($row["preferences_json"]);
        $user->setCreatedAt($row["created_at"]);
        $user->setId((int)($row["id"]));
        return $user;
    }
    public function findById(int $id): User {
        $stmt = $this->db->prepare("SELECT * FROM users 
                                    WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($result)) {
            throw new NotFoundException("User with id {$id} not found!");
        }
        return $this->hydrate($result);
    }
    public function findAll() : array {
        $stmt = $this->db->query("SELECT * FROM users");
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map($this->hydrate(...), $result);
    }

    public function findByUsername(string $username) : ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $this->hydrate($result);
    }
    public function findByEmail(string $email) : ?User {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $this->hydrate($result);
    }

    public function create(User $user) : int {
        $stmt = $this->db->prepare("INSERT INTO users VALUES ?");
        $stmt->execute([$user->getId()]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $result["id"];
    }

    public function existsByUsername(string $username) : bool {
        $stmt = $this->db->prepare("SELECT 1 FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return empty($result);
    }

    public function existsByEmail(string $email) : bool {
        $stmt = $this->db->prepare("SELECT 1 FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return empty($result);
    }
}