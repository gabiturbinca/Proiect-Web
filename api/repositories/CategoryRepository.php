<?php

class CategoryRepository {
    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }
    /**
     * 
     * @param int $id ID-ul categoriei
     * @param bool $activeOnly Filtreaza doar categoriile active
     * @return array Datele categoriei
     * @throws NotFoundException Daca categoria nu exista
     */
    public function findById($id, $activeOnly = true) {
        $sql = "SELECT * FROM categories WHERE id = ?";
        if ($activeOnly) {
            $sql .= " AND is_active = true";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if (!$result) {
            throw new NotFoundException("Category not found");
        }
        return $result;
    }

    public function findAll($activeOnly = true) {
        $sql = "SELECT * FROM categories";
        if ($activeOnly) {
            $sql .= " WHERE is_active = true";
        }
        $sql .= " ORDER BY sort_order ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function findShortCategories($activeOnly = true) {
        $sql = "SELECT id, name, description, image_url FROM categories";
        if ($activeOnly) {
            $sql .= " WHERE is_active = true";
        }
        $sql .= " ORDER BY sort_order ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function findIdNameCategories($activeOnly = true) {
        $sql = "SELECT id, name FROM categories";
        if ($activeOnly) {
            $sql .= " WHERE is_active = true";
        }
        $sql .= " ORDER BY sort_order ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}