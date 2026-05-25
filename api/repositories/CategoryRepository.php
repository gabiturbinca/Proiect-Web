<?php


class CategoryRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function hydrate(array $r): Category {
        $c = new Category();
        $c->setId ((int)$r['id']);
        $c->setName ($r['name']);
        $c->setDescription ($r['description']);
        $c->setImageUrl ($r['image_url'] ?? null);
        $c->setIsActive ((bool)$r['is_active']);
        $c->setSortOrder ((int)$r['sort_order']);
        $c->setCreatedAt ($r['created_at']);
        return $c;
    }

    public function findById($id, $activeOnly = true): Category {
        $sql = "SELECT * FROM categories WHERE id = ?";
        if ($activeOnly) {
            $sql .= " AND is_active = true";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            throw new NotFoundException("Category not found");
        }
        return $this->hydrate($row);
    }

    public function findAll($activeOnly = true): array {
        $sql = "SELECT * FROM categories";
        if ($activeOnly) {
            $sql .= " WHERE is_active = true";
        }
        $sql .= " ORDER BY sort_order ASC";
        $stmt = $this->db->query($sql);
        return array_map($this->hydrate(...), $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function create(Category $category): Category {
        $stmt = $this->db->prepare(
            "INSERT INTO categories (name, description, image_url, is_active, sort_order)
             VALUES (?, ?, ?, ?, ?)
             RETURNING id, created_at"
        );
        $stmt->execute([
            $category->getName(),
            $category->getDescription(),
            $category->getImageUrl(),
            $category->getIsActive(),
            $category->getSortOrder(),
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $category->setId((int) $row['id']);
        $category->setCreatedAt($row['created_at']);
        return $category;
    }

    public function update(int $id, array $fields): void {
        if (empty($fields)) return;
        $sets = [];
        $params = [];
        foreach ($fields as $column => $value) {
            $sets[] = "$column = ?";
            $params[] = $value;
        }
        $params[] = $id;
        $sql = "UPDATE categories SET " . implode(', ', $sets) . " WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
    }

    public function delete(int $id): void {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function existsByName(string $name, ?int $excludeId = null): bool {
        if ($excludeId === null) {
            $stmt = $this->db->prepare("SELECT 1 FROM categories WHERE name = ?");
            $stmt->execute([$name]);
        } else {
            $stmt = $this->db->prepare("SELECT 1 FROM categories WHERE name = ? AND id <> ?");
            $stmt->execute([$name, $excludeId]);
        }
        return (bool) $stmt->fetchColumn();
    }
}
