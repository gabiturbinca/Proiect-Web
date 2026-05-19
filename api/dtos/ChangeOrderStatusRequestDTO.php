<?php

readonly class ChangeOrderStatusRequestDTO {
    public const RULES = [
        'status' => ['required'],
    ];

    public function __construct(public string $status) {}
}