<?php

class UserRepository {

    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private const SELECT_COLUMNS = "id, username, email, password_hash, role, preferences_json, created_at, must_change_password, EXTRACT(EPOCH FROM password_changed_at)::bigint AS password_changed_at";

    public function hydrate (array $row) : ?User{
        $user = new User();
        $user->setUsername($row["username"]);
        $user->setEmail($row["email"]);
        $user->setPasswordHash($row["password_hash"]);
        $user->setUserRole($row["role"]);
        $user->setPreferencesJson($row["preferences_json"]);
        $user->setCreatedAt($row["created_at"]);
        $user->setId((int)($row["id"]));
        $user->setMustChangePassword((bool) $row["must_change_password"]);
        $user->setPasswordChangedAt((int) $row["password_changed_at"]);
        return $user;
    }
    public function findById(int $id): User {
        $sql = "SELECT " . self::SELECT_COLUMNS . " FROM users WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if(empty($result)) {
            throw new NotFoundException("User with id {$id} not found!");
        }
        return $this->hydrate($result);
    }
    public function findAll() : array {
        $sql = "SELECT " . self::SELECT_COLUMNS . " FROM users";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map($this->hydrate(...), $result);
    }

    public function findByUsername(string $username) : ?User {
        $sql = "SELECT " . self::SELECT_COLUMNS . " FROM users WHERE username = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $this->hydrate($result): null;
    }
    public function findByEmail(string $email) : ?User {
        $sql = "SELECT " . self::SELECT_COLUMNS . " FROM users WHERE email = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $this->hydrate($result) : null;
    }

    public function create(User $user) : User {
        $stmt = $this->db->prepare(
        "INSERT INTO users (username, email, password_hash)
         VALUES (?, ?, ?)
         RETURNING id, role, created_at, must_change_password,
                   EXTRACT(EPOCH FROM password_changed_at)::bigint AS password_changed_at"
        );
        $stmt->execute([
            $user->getUsername(),
            $user->getEmail(),
            $user->getPasswordHash(),
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user->setId((int) $row["id"]);
        $user->setCreatedAt($row["created_at"]);
        $user->setUserRole($row["role"]);
        $user->setMustChangePassword((bool) $row["must_change_password"]);
        $user->setPasswordChangedAt((int) $row["password_changed_at"]);
        return $user;
    }

    public function existsByUsername(string $username) : bool {
        $stmt = $this->db->prepare("SELECT 1 FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($result);
    }

    public function existsByEmail(string $email) : bool {
        $stmt = $this->db->prepare("SELECT 1 FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return !empty($result);
    }

    public function updatePassword(int $userId, string $password_hash): void {
        $stmt = $this->db->prepare(
            "UPDATE users SET password_hash = ?, password_changed_at = (NOW() AT TIME ZONE 'UTC') WHERE id = ?"
        );
        $stmt->execute([$password_hash, $userId]);
    }
    public function setMustChangePassword(int $userId, bool $value): void {
        $stmt = $this->db->prepare("UPDATE users SET must_change_password = ? WHERE id = ?");
        $stmt->execute([(int) $value, $userId]);
    }


}