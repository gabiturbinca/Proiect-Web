<?php

class OrderController {
    public function __construct(
        private OrderService $orderService,
        private CurrentUserDTO $current,
    ) {}

    public function create(): OrderDTO {

    }
    public function index(): array {

    }
    public function show(int $id) : OrderDTO {
    }
    public function cancel(int $id) : OrderDTO {
        
    }
}