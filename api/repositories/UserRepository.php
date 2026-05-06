<?php

class UserRepository {

    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function hydrate (array $row) {
        $user = new User();
        $user->setUsername($row["username"]);
        $user->setEmail($row["email"]);
        $user->setPassword($row["password"]);
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
}