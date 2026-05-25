<?php


class CircumstanceRepository {
    
    public function __construct(public PDO $db) {}
    public function hydrate(array $row) : Circumstance {
        $c = new Circumstance();
        $c->setId((int) $row["id"]);
        $c->setName( (string) $row["name"]);
        $c->setDescription($row["description"]);
        $c->setCreatedAt($row["created_at"]);
        return $c;
    }
    public  function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM circumstances");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map($this->hydrate(...), $rows);
    }

}