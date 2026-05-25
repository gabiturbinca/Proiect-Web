<?php

class AdminOrderController {
    public function __construct(
        private OrderService $orderService
    ) {}

    public function index(): array {
    $status     = $_GET['status'] ?? null;
    $from       = $_GET['from'] ?? null;
    $to         = $_GET['to'] ?? null;
    $elemNumber = (int) ($_GET['elemNumber'] ?? 10);
    $pageNumber = (int) ($_GET['pageNumber'] ?? 1);
    return $this->orderService->adminList($status, $from, $to, $pageNumber, $elemNumber);
    }

    public function changeStatus(int $orderId): OrderDTO {
    $input = json_decode(file_get_contents('php://input'), true) ?? [];
    $data = Validator::make($input, ChangeOrderStatusRequestDTO::RULES)->validate();
    return $this->orderService->adminChangeStatus($orderId, $data['status']);
}
}