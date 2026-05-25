<?php


class CircumstanceService {
    
    public function __construct(
        private CircumstanceRepository $cRepo
    ) {}

    public function getAll(): array {
        $circumstances = $this->cRepo->findAll();
        return array_map(fn(Circumstance $c) => $this->toDto($c), $circumstances);

    }
    public function toDto(Circumstance $c): CircumstanceDTO {
        return new CircumstanceDTO($c->getId(), $c->getName());
    }
}