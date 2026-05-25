<?php

class OrderController {
    public function __construct(
        private OrderService $orderService,
        private CurrentUserDTO $current,
    ) {}

    public function create(): OrderDTO {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $data = Validator::make($input, CreateOrderRequestDTO::RULES)->validate();
        $dto = new CreateOrderRequestDTO(
            gift_id:        (int) $data['gift_id'],
            quantity:       (int) $data['quantity'],
            address:        $data['address'],
            description:    $data['description'] ?? null,
            is_anonymous:   filter_var($data['is_anonymous'] ?? false, FILTER_VALIDATE_BOOLEAN),
            recipient_name: $data['recipient_name'],
        );
        return $this->orderService->create($this->current->id, $dto);
    }
    public function index(): array {
        $elemNumber = (int) ($_GET['elemNumber'] ?? 10);
        $pageNumber = (int) ($_GET['pageNumber'] ?? 1);
        return $this->orderService->listMyOrders($this->current->id, $pageNumber, $elemNumber);
    }
    public function show(int $id) : OrderDTO {
        return $this->orderService->getMyOrder($this->current->id, $id);
    }
    public function cancel(int $id) : OrderDTO {
        return $this->orderService->cancelMyOrder($this->current->id, $id);
    }
}