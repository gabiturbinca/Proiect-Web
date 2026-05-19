<?php

class AdminOrderController {
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index() : array {

    }

    public function changeStatus(int $orderId) :OrderDTO {
        
    }
}