<?php

class CircumstanceController
{
    public function __construct(
        private CircumstanceService $cServ
    ) {}

    public function index (): array {
        return $this->cServ->getAll();
    }
}