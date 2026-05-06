<?php

readonly class LoginRequestDTO {
    public function __construct (
        //poate fi email sau parola 
        public $identifier,
        public string $password,
    ) {}
}