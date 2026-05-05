<?php


class CategoryRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function hydrate(array $r): Category {
        $c = new Category();
        $c->id = (int)$r['id'];
        $c->name = $r['name'];
        $c->description = $r['description'];
        $c->image_url = $r['image_url'] ?? null;
        $c->is_active = (bool)$r['is_active'];
        $c->sort_order = (int)$r['sort_order'];
        $c->created_at = $r['created_at'];
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

    public function findShortCategories($activeOnly = true): array {
        $sql = "SELECT id, name, description, image_url FROM categories";
        if ($activeOnly) {
            $sql .= " WHERE is_active = true";
        }
        $sql .= " ORDER BY sort_order ASC";
        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($r) => new IdNameDescImgCategoryDTO(
            id: (int)$r['id'],
            name: $r['name'],
            image_url: $r['image_url'],
            description: $r['description']
        ), $rows);
    }

    public function findIdNameCategories($activeOnly = true): array {
        $sql = "SELECT id, name FROM categories";
        if ($activeOnly) {
            $sql .= " WHERE is_active = true";
        }
        $sql .= " ORDER BY sort_order ASC";
        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(fn($r) => new IdNameCategoryDTO(
            id: (int)$r['id'],
            name: $r['name']
        ), $rows);
    }
}
