<?php


class ReportRepository {
    public function __construct(
        private PDO $db
    ) {}

    public function fetchUsersReport(?string $from, ?string $to):array {
        $whereStmt = [];
        $params = [];

        if($from != null) {
            $whereStmt []= ' u.created_at >= ?';
            $params[] = $from;
        }
        if($to != null) {
            $whereStmt []= ' u.created_at <= ?';
            $params[] = $to;
        }

        $sql = 
            "SELECT u.id as id, u.username AS username, u.email AS email, 
            COALESCE(COUNT(o.id), 0) as order_number,
            COALESCE(SUM(o.total_price), 0) as total_spent
            FROM users u 
            LEFT JOIN orders o ON u.id = o.user_id
            AND o.status != 'cancelled' 
        ";
        if(count($params) > 0) {
            $sql .= 'WHERE ' . implode(' AND ', $whereStmt);
        }
        $sql .= ' GROUP BY u.id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fetchOrdersReport(?string $from, ?string $to, ?int $cat): array {
        $whereStmt = [];
        $params = [];

        if($from != null) {
            $whereStmt []= ' o.created_at >= ?';
            $params[] = $from;
        }
        if($to != null) {
            $whereStmt []= ' o.created_at <= ?';
            $params[] = $to;
        }
        if($cat != null) {
            $whereStmt [] = ' c.id = ?';
            $params[] = $cat;
        }
        $sql = 
            "SELECT o.id AS id, g.name AS gift_name,
             u.username AS username, o.quantity AS quantity,
             o.total_price AS total_price, o.status AS status,
             o.created_at AS created_at FROM
             orders o LEFT JOIN users u ON o.user_id = u.id
             LEFT JOIN gifts g on o.gift_id = g.id
             LEFT JOIN categories c on g.category_id = c.id 
        ";
        if(count($params) > 0) {
            $sql .= 'WHERE ' . implode(' AND ', $whereStmt);
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function fetchCategoriesReport(?string $from, ?string $to): array {
        $from = $from ?? '1900-01-01';
        $to = $to ?? date('Y-m-d H:i:s');
        $sql = "SELECT c.id, c.name AS category_name, 
                    COALESCE(SUM(o.total_price), 0) AS total_revenue
                FROM categories c
                LEFT JOIN gifts g ON g.category_id = c.id
                LEFT JOIN orders o ON o.gift_id = g.id 
                                AND o.created_at BETWEEN ? AND ?
                                AND o.status != 'cancelled'
                GROUP BY c.id, c.name";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$from, $to]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}