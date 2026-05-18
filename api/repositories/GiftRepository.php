<?php

class GiftRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function hydrate(array $row): Gift {
        $gift = new Gift();
        $gift->setId ( (int)$row['id']);
        $gift->setName ( $row['name']);
        $gift->setDescription ( $row['description']);
        $gift->setPrice ((float) $row['price']);
        $gift->setCategoryId ( $row['category_id'] !== null ? (int)$row['category_id'] : null);
        $gift->setSpecifications ( $row['specifications'] !== null ? json_decode($row['specifications'], true) : null);
        $gift->setCreatedAt ($row['created_at']);
        $gift->setBrandId ( $row['brand_id'] !== null ? (int)$row['brand_id'] : null);
        $gift->setImageUrl ( $row['image_url']);
        $gift->setScore ( (float)$row['score']);
        $gift->setChosenCount ( (int)$row['chosen_count']);
        $gift->setCategoryName ( $row['category_name'] ?? null);
        $gift->setBrandName ( $row['brand_name'] ?? null);
        return $gift;
    }
    private function loadCircumstanceIds(array $gifts): void {
        if (empty($gifts)) return;
        $ids = array_map(fn(Gift $g) => $g->getId(), $gifts);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        
        $stmt = $this->db->prepare(
            "SELECT gift_id, circumstance_id FROM gift_circumstances WHERE gift_id IN ($placeholders)"
        );
        $stmt->execute($ids);
        
        $byGift = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $byGift[(int)$row['gift_id']][] = (int)$row['circumstance_id'];
        }
        
        foreach ($gifts as $g) {
            $g->setCircumstanceIds($byGift[$g->getId()] ?? []);
        }
    }
    private function loadContextIds(array $gifts): void {
        if (empty($gifts)) return;
        $ids = array_map(fn(Gift $g) => $g->getId(), $gifts);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        
        $stmt = $this->db->prepare(
            "SELECT gift_id, context_id FROM gift_contexts WHERE gift_id IN ($placeholders)"
        );
        $stmt->execute($ids);
        
        $byGift = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $byGift[(int)$row['gift_id']][] = (int)$row['context_id'];
        }
        
        foreach ($gifts as $g) {
            $g->setContextIds($byGift[$g->getId()] ?? []);
        }
    }
    private function hydrateTag(array $row): Tag {
        $tag = new Tag();
        $tag->setId ( (int)$row['id']);
        $tag->setName ( $row['name']);
        $tag->setSlug ($row['slug']);
        return $tag;
    }

    private function loadTags(array $gifts): void {
        if (empty($gifts)) return;

        $ids = array_map(fn(Gift $g) => $g->getId(), $gifts);
        $placeholders = implode(',', array_fill(0, count($ids), '?'));

        $stmt = $this->db->prepare(
            "SELECT gt.gift_id, t.id, t.name, t.slug
             FROM gift_tags gt
             JOIN tags t ON gt.tag_id = t.id
             WHERE gt.gift_id IN ($placeholders)"
        );
        $stmt->execute($ids);

        $tagsByGift = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $tagsByGift[(int)$row['gift_id']][] = $this->hydrateTag($row);
        }

        foreach ($gifts as $g) {
            $g->setTags($tagsByGift[$g->getId()] ?? []);
        }
    }

    public function findById($id): Gift {
        $stmt = $this->db->prepare(
            "SELECT g.*, c.name AS category_name, b.name AS brand_name
             FROM gifts g
             LEFT JOIN categories c ON g.category_id = c.id
             LEFT JOIN brands b ON g.brand_id = b.id
             WHERE g.id = ?"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            throw new NotFoundException("Gift not found");
        }
        $gift = $this->hydrate($row);
        $this->loadTags([$gift]);
        return $gift;
    }

    public function getGiftsCount(): int {
        $stmt = $this->db->query(
            "SELECT COUNT(*) FROM gifts g
             JOIN categories c ON g.category_id = c.id
             WHERE c.is_active = true"
        );
        return (int)$stmt->fetchColumn();
    }

    public function findAll($elemNumber, $offset): array {
        $stmt = $this->db->prepare(
            "SELECT g.*, c.name AS category_name, b.name AS brand_name
             FROM gifts g
             JOIN categories c ON g.category_id = c.id
             LEFT JOIN brands b ON g.brand_id = b.id
             WHERE c.is_active = true
             ORDER BY g.created_at DESC
             LIMIT ? OFFSET ?"
        );
        $stmt->execute([$elemNumber, $offset]);
        $gifts = array_map($this->hydrate(...), $stmt->fetchAll(PDO::FETCH_ASSOC));
        $this->loadTags($gifts);
        return $gifts;
    }

    public function getGiftsCountByCategory($categoryId): int {
        $stmt = $this->db->prepare(
            "SELECT COUNT(*) FROM gifts g
             JOIN categories c ON g.category_id = c.id
             WHERE c.id = ? AND c.is_active = true"
        );
        $stmt->execute([$categoryId]);
        return (int)$stmt->fetchColumn();
    }

    public function findAllByCategory($categoryId, $elemNumber, $offset): array {
        $stmt = $this->db->prepare(
            "SELECT g.*, c.name AS category_name, b.name AS brand_name
             FROM gifts g
             JOIN categories c ON g.category_id = c.id
             LEFT JOIN brands b ON g.brand_id = b.id
             WHERE c.id = ? AND c.is_active = true
             ORDER BY g.created_at DESC
             LIMIT ? OFFSET ?"
        );
        $stmt->execute([$categoryId, $elemNumber, $offset]);
        $gifts = array_map($this->hydrate(...), $stmt->fetchAll(PDO::FETCH_ASSOC));
        $this->loadTags($gifts);
        return $gifts;
    }
    public function findCandidates(RecommendationRequestDTO $req): array {
        $where = ["c.is_active = true"];
        $params = [];
        
        if ($req->categoryId !== null) {
            $where[] = "g.category_id = ?";
            $params[] = $req->categoryId;
        }
        if ($req->brandId !== null) {
            $where[] = "g.brand_id = ?";
            $params[] = $req->brandId;
        }
        if ($req->budgetMin !== null) {
            $where[] = "g.price >= ?";
            $params[] = $req->budgetMin;
        }
        if ($req->budgetMax !== null) {
            $where[] = "g.price <= ?";
            $params[] = $req->budgetMax;
        }
        
        $whereClause = implode(' AND ', $where);
        
        $sql = "SELECT g.*, c.name AS category_name, b.name AS brand_name
                FROM gifts g
                JOIN categories c ON g.category_id = c.id
                LEFT JOIN brands b ON g.brand_id = b.id
                WHERE $whereClause";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        
        $gifts = array_map($this->hydrate(...), $stmt->fetchAll(PDO::FETCH_ASSOC));
        $this->loadTags($gifts);
        $this->loadCircumstanceIds($gifts); 
        $this->loadContextIds($gifts);
        return $gifts;
    }

}
