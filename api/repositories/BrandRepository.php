<?php

class BrandRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function hydrate(array $r): Brand {
        $b = new Brand();
        $b->setId ( (int)$r['id']);
        $b->setName ( $r['name']);
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

    public function findByName(string $name): ?Brand {
        $stmt = $this->db->prepare("SELECT * FROM brands WHERE LOWER(name) = LOWER(?)");
        $stmt->execute([$name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $this->hydrate($row) : null;
    }

    public function create(Brand $brand): Brand {
        $stmt = $this->db->prepare("INSERT INTO brands (name) VALUES (?) RETURNING id");
        $stmt->execute([$brand->getName()]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $brand->setId((int) $row['id']);
        return $brand;
    }
}
