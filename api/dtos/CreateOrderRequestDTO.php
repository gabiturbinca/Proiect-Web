<?php

final readonly class CreateOrderRequestDTO {
    public const RULES = [
    'gift_id'         => ['required', 'numeric_id'],
    'quantity'        => ['required', 'numeric_min:1', 'numeric_max:100'],
    'address'         => ['required', 'min:5', 'max:255'],
    'recipient_name'  => ['max:255'],
    'description'     => ['max:500'],
    'is_anonymous'    => [],
    ];
    public function __construct(
        public int $gift_id,
        public int $quantity,
        public string $address,
        public ?string $description,
        public bool $is_anonymous,
        public string $recipient_name
    ) {}
}