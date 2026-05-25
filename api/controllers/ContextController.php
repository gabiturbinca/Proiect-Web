<?php


class ContextController {

    public function __construct(
        private ContextService $cServ
    ) {}

    public function index (): array {
        return $this->cServ->getAll();
    }
}