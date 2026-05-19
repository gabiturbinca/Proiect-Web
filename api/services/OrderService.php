<?php

class OrderService {

    public function __construct(
        private OrderRepository $orderRepository,
        private GiftRepository $giftRepository) 
        {}
    public function create(int $userId, CreateOrderRequestDTO $oDTO) : OrderDTO {

    }
    public function getMyOrder(int $userId, int $orderId) : OrderDTO {
    }
    public function listMyOrders(int $userId, int $orderId, int $page, int $limit) : array {
    }
    public function cancelMyOrder(int $userId, int $orderId) : OrderDTO {
    }
    public function adminList(?string $status, ?string $from, ?string $to, int $page, int $limit) :array {

    }
    public function adminChangeStatus(int $orderId, string $newStatus) :OrderDTO {
        
    }   
}