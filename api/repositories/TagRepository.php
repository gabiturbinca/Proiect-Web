<?php

class TagRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function hydrate(array $r): Tag {
        $t = new Tag();
        $t->id = (int)$r['id'];
        $t->name = $r['name'];
        $t->slug = $r['slug'];
        return $t;
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM tags");
        return array_map($this->hydrate(...), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findById($id): Tag {
        $stmt = $this->db->prepare("SELECT * FROM tags WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            throw new NotFoundException("Tag not found");
        }
        return $this->hydrate($row);
    }
}
