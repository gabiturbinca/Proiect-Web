<?php


class ContextRepository {
    
    public function __construct(public PDO $db) {}
    public function hydrate(array $row) : Context {
        $c = new Context();
        $c->setId((int) $row["id"]);
        $c->setName( (string) $row["name"]);
        $c->setDescription($row["description"]);
        return $c;
    }
    public  function findAll(): array {
        $stmt = $this->db->query("SELECT * FROM contexts");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map($this->hydrate(...), $rows);
    }

}