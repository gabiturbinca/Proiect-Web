<?php

class BrandRepository {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM brands");
        return $stmt->fetchAll();
    }
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM brands WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if(empty($result)) {
            throw new NotFoundException("Brand not found");
        }
        return $result;
    }

    
}