<?php

class BrandRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function hydrate(array $r): Brand {
        $b = new Brand();
        $b->id = (int)$r['id'];
        $b->name = $r['name'];
        return $b;
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM brands");
        return array_map($this->hydrate(...), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findById($id): Brand {
        $stmt = $this->db->prepare("SELECT * FROM brands WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            throw new NotFoundException("Brand not found");
        }
        return $this->hydrate($row);
    }
}
