<?php

class OrderService {
    private const VALID_TRANSITIONS = [
        'placed'    => ['shipped', 'cancelled'],
        'shipped'   => ['delivered'],
        'delivered' => [],
        'cancelled' => ['placed'],
    ];

    public function __construct(
        private OrderRepository $orderRepository,
        private GiftRepository $giftRepository,
    ) {}

    public function create(int $userId, CreateOrderRequestDTO $oDTO): OrderDTO {
        $gift = $this->giftRepository->findById($oDTO->gift_id);

        $order = new Order();
        $order->setUserId($userId);
        $order->setGiftId($oDTO->gift_id);
        $order->setAddress($oDTO->address);
        $order->setQuantity($oDTO->quantity);
        $order->setIsAnonymous($oDTO->is_anonymous);
        $order->setDescription($oDTO->description);
        $order->setRecipientName($oDTO->recipient_name);
        $order->setGiftPrice($gift->getPrice());
        $order->setTotalPrice($gift->getPrice() * $oDTO->quantity);
        $order->setStatus(OrderStatus::PLACED->value);
        $order = $this->orderRepository->create($order);
        $full = $this->orderRepository->findById($order->getId());
        $this->giftRepository->refreshChosenCount($oDTO->gift_id);
        return $this->toDTO($full);
    }

    public function getMyOrder(int $userId, int $orderId): OrderDTO {
        $order = $this->orderRepository->findById($orderId);
        if ($order->getUserId() !== $userId) {
            throw new NotFoundException("Order not found");
        }
        return $this->toDTO($order);
    }

    public function listMyOrders(int $userId, int $page, int $limit): array {
        $offset = ($page - 1) * $limit;
        $orders = $this->orderRepository->findAllByUserId($userId, $limit, $offset);
        return [
            'orders'       => array_map(fn($o) => $this->toDTO($o), $orders),
            'orders_count' => $this->orderRepository->countByUserId($userId),
        ];
    }

    public function cancelMyOrder(int $userId, int $orderId): OrderDTO {
        $order = $this->orderRepository->findById($orderId);
        if ($order->getUserId() !== $userId) {
            throw new NotFoundException("Order not found");
        }
        if ($order->getStatus() !== OrderStatus::PLACED->value) {
            throw new ConflictException(['order' => ['Cannot cancel order in current status']]);
        }
        $this->orderRepository->updateStatus($orderId, OrderStatus::CANCELLED->value);
        return $this->toDTO($this->orderRepository->findById($orderId));
    }

    public function adminList(?string $status, ?string $from, ?string $to, int $page, int $limit): array {
        $offset = ($page - 1) * $limit;
        $orders = $this->orderRepository->findAll($status, $from, $to, $limit, $offset);
        return [
            'orders'       => array_map(fn($o) => $this->toDTO($o), $orders),
            'orders_count' => $this->orderRepository->countAll($status, $from, $to),
        ];
    }

    public function adminChangeStatus(int $orderId, string $newStatus): OrderDTO {
        $order = $this->orderRepository->findById($orderId);
        $current = $order->getStatus();
        $allowed = self::VALID_TRANSITIONS[$current] ?? [];
        if (!in_array($newStatus, $allowed, true)) {
            throw new ConflictException(['order' => ["Cannot transition from $current to $newStatus"]]);
        }
        $this->orderRepository->updateStatus($orderId, $newStatus);
        return $this->toDTO($this->orderRepository->findById($orderId));
    }

    public function toDTO(Order $order): OrderDTO {
        return new OrderDTO(
            $order->getId(),
            $order->getGiftId(),
            $order->getGiftName(),
            $order->getGiftPrice(),
            $order->getQuantity(),
            $order->getTotalPrice(),
            $order->getStatus(),
            $order->getCreatedAt(),
            $order->getLastUpdated(),
            $order->getAddress(),
            $order->getIsAnonymous(),
            $order->getDescription(),
            $order->getRecipientName(),
            $order->getUsername(),
        );
    }
}
