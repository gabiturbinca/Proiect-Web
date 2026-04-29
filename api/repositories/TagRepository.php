<?php

class TagRepository {
    private PDO $db;
    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM tags");
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM tags WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if(empty($result)) {
            throw new NotFoundException("Tag not found");
        }
        return $result;
    }
}