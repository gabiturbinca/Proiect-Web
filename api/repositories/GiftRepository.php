<?php

class GiftRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findById($id) {
        $stmt = $this->db->prepare(
            "SELECT g.*, c.name as category_name , b.name as brand_name 
            FROM gifts g LEFT JOIN categories c on g.category_id = c.id 
            LEFT JOIN brands b on g.brand_id = b.id WHERE g.id = ?");
        $stmt->execute([$id]);

        $result = $stmt->fetch();
        if(empty($result)) {
            throw new NotFoundException("Gift not found");
        }

        $stmt = $this->db->prepare("SELECT t.id as tag_id, t.name as tag_name FROM gift_tags gt
                                   join tags t on gt.tag_id = t.id where gt.gift_id = ?");
        $stmt->execute([$id]);
        $result['tags'] = $stmt->fetchAll();
        return $result;
    }
    public function getGiftsCount() {
        $stmt = $this->db->query("SELECT COUNT(*) FROM gifts g 
                                JOIN categories c ON g.category_id = c.id 
                                WHERE c.is_active = true");
        return $stmt->fetchColumn();
    }
    public function findAll($elemNumber, $offset) {
        $stmt = $this->db->prepare(
            "SELECT g.*, c.name as category_name , b.name as brand_name 
            FROM gifts g 
            JOIN categories c on g.category_id = c.id 
            LEFT JOIN brands b on g.brand_id = b.id 
            WHERE c.is_active = true 
            ORDER BY g.created_at 
            DESC LIMIT ? OFFSET ?");
        $stmt->execute([$elemNumber, $offset]);
        $gifts = $stmt->fetchAll();

        return [
            'gifts' => $gifts,
            'gifts_count' => $this->getGiftsCount()
        ];
    }

    public function getGiftsCountByCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM gifts g 
                                    JOIN categories c ON g.category_id = c.id 
                                    WHERE c.id = ? AND c.is_active = true");
        $stmt->execute([$categoryId]);
        return $stmt->fetchColumn();
    }
    public function findAllByCategory($categoryId, $elemNumber, $offset) {
        $stmt = $this->db->prepare(
            "SELECT g.*, c.name as category_name , b.name as brand_name 
            FROM gifts g JOIN categories c on g.category_id = c.id 
            LEFT JOIN brands b on g.brand_id = b.id WHERE c.id = ? AND c.is_active = true 
            ORDER BY g.created_at DESC LIMIT ? OFFSET ?");
        $stmt->execute([$categoryId, $elemNumber, $offset]);
        $gifts = $stmt->fetchAll();

        return [
            'gifts' => $gifts,
            'gifts_count' => $this->getGiftsCountByCategory($categoryId)
        ];
    }

}