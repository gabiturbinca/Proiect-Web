<?php

class OrderRepository {
    public function __construct(private PDO $db) {}

    private function hydrate(array $row): Order {
        $o = new Order();
        $o->setId((int)$row["id"]);
        $o->setUserId((int)$row["user_id"]);
        $o->setGiftId((int)$row["gift_id"]);
        $o->setTotalPrice((float)$row["total_price"]);
        $o->setStatus($row["status"]);
        $o->setCreatedAt($row["created_at"]);
        $o->setLastUpdated($row["last_updated"]);
        $o->setAddress($row["address"]);
        $o->setIsAnonymous((bool)$row["is_anonymous"]);
        $o->setDescription($row["description"]);
        $o->setRecipientName($row["recipient_name"]);
        $o->setGiftPrice($row["gift_price"]);
        $o->setUsername($row["username"]);
        $o->setGiftName($row["gift_name"]);
        $o->setQuantity($row["quantity"]);
        return $o;
    }
    public function findById(int $id): Order {
        $stmt = $this->db->prepare(
        "SELECT o.*, u.username AS username, g.name AS gift_name,
        g.price AS gift_price FROM
        orders o JOIN users u ON o.user_id = u.id
        JOIN gifts g ON o.gift_id = g.id 
        WHERE o.id = ?"
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$row) {
            throw new NotFoundException("Order not found!");
        }
        return $this->hydrate($row);
    }
    public function findAllByUserId(int $userId, int $limit, int $offset): array {
        $stmt = $this->db->prepare(
        "SELECT o.*, u.username AS username, g.name AS gift_name,
        g.price AS gift_price FROM
        orders o JOIN users u ON o.user_id = u.id
        JOIN gifts g ON o.gift_id = g.id 
        WHERE u.id = ?
        ORDER BY o.created_at DESC
        LIMIT ? OFFSET ?"
        );
        $stmt->execute([$userId, $limit, $offset]);
        $orders = array_map($this->hydrate(...), $stmt->fetchAll(PDO::FETCH_ASSOC));
        return $orders;
    }
    public function countByUserId(int $userId): int {
        $stmt = $this->db->prepare(
            "SELECT COUNT(1) FROM orders
            WHERE user_id = ?"
            );
        $stmt->execute([$userId]);
        return (int)$stmt->fetchColumn(); 
    }

    public function create(Order $order): Order {
        $stmt = $this->db->prepare(
            "INSERT INTO orders(user_id, gift_id, quantity, total_price,
            status, address, is_anonymous, description, recipient_name)
            VALUES(?, ?, ?, ?, ?, ? , ?, ?, ?)
            RETURNING id, created_at, last_updated"
            );
        $stmt->execute([
            $order->getUserId(),
            $order->getGiftId(),
            $order->getQuantity(),
            $order->getTotalPrice(),
            $order->getStatus(),
            $order->getAddress(),
            (int) $order->getIsAnonymous(),
            $order->getDescription(),
            $order->getRecipientName(),
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $order->setId($row["id"]);
        $order->setCreatedAt($row["created_at"]);
        $order->setLastUpdated($row["last_updated"]);
        return $order;
    }
    public function updateStatus(int $id, string $newStatus): void {
        $stmt = $this->db->prepare(
            "UPDATE orders SET status = ? 
            WHERE id = ?"
            );
        $stmt->execute([$newStatus, $id]);
    }
    public function countAll(?string $status, ?string $from, ?string $to): int {
        $where = [];
        $params = [];
        if ($status !== null) {
            $where[] = "status = ?::order_status";
            $params[] = $status;
        }
        if ($from !== null) {
            $where[] = "created_at >= ?";
            $params[] = $from;
        }
        if ($to !== null) {
            $where[] = "created_at <= ?";
            $params[] = $to;
        }
        $whereStmt = empty($where) ? '' : 'WHERE ' . implode(' AND ', $where);
        $stmt = $this->db->prepare("SELECT COUNT(1) FROM orders $whereStmt");
        $stmt->execute($params);
        return (int) $stmt->fetchColumn();
    }

    public function findAll(?string $status, ?string $from, ?string $to, int $limit, int $offset): array {
        $where = [];
        $params = [];
        if ($status !== null) {
            $where[] = "status = ?::order_status";
            $params[] = $status;
        }
        if ($from !== null) {
            $where[] = "o.created_at >= ?";
            $params[] = $from;
        }
        if ($to !== null) {
            $where[] = "o.created_at <= ?";
            $params[] = $to;
        }
        $whereStmt = empty($where) ? '' :'WHERE '.implode(' AND ', $where);
        $stmt = $this->db->prepare(
        "SELECT o.*, u.username AS username, g.name AS gift_name,
        g.price AS gift_price FROM
        orders o JOIN users u ON o.user_id = u.id
        JOIN gifts g ON o.gift_id = g.id
        $whereStmt 
        ORDER BY o.created_at DESC
        LIMIT ? OFFSET ?"
        );
        $params []= $limit;
        $params []= $offset;
        $stmt->execute($params);
        $orders = array_map($this->hydrate(...), $stmt->fetchAll(PDO::FETCH_ASSOC));
        return $orders;
    }
}