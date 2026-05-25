<?php


final readonly class ResetAsUnkownDTO {
    public function __construct(
        public string $identifier,
        public ?string $message
    ) {}
     public const RULES = [
    'identifier' => ['required'],
    'message' => []
    ];
}