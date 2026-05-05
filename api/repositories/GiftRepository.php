<?php

class GiftRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    private function hydrate(array $r): Gift {
        $g = new Gift();
        $g->id = (int)$r['id'];
        $g->name = $r['name'];
        $g->description = $r['description'];
        $g->price = $r['price'];
        $g->category_id = $r['category_id'] !== null ? (int)$r['category_id'] : null;
        $g->specifications = $r['specifications'] !== null ? json_decode($r['specifications'], true) : null;
        $g->created_at = $r['created_at'];
        $g->brand_id = $r['brand_id'] !== null ? (int)$r['brand_id'] : null;
        $g->image_url = $r['image_url'];
        $g->score = $r['score'];
        $g->chosen_count = (int)$r['chosen_count'];
        $g->category_name = $r['category_name'] ?? null;
        $g->brand_name = $r['brand_name'] ?? null;
        return $g;
    }

    private function hydrateTag(array $r): Tag {
        $t = new Tag();
        $t->id = (int)$r['id'];
        $t->name = $r['name'];
        $t->slug = $r['slug'];
        return $t;
    }

    private function loadTags(array $gifts): void {
        if (empty($gifts)) return;

        $ids = array_map(fn(Gift $g) => $g->id, $gifts);
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
            $g->setTags($tagsByGift[$g->id] ?? []);
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
}
