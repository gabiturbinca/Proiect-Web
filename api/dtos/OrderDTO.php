<?php

final readonly class OrderDTO {
    public function __construct(
        public int      $id,
        public int      $gift_id,
        public string   $gift_name,
        public float    $gift_price,
        public int      $quantity,
        public float    $total_price,
        public string   $status,
        public string   $created_at,
        public string   $last_updated,
        public string   $address,
        public bool     $is_anonymous,
        public ?string  $description,
        public ?string  $recipient_name,
        public ?string  $username,
    ) {}
}
