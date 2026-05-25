<?php


class ContextService {
    
    public function __construct(
        private ContextRepository $cRepo
    ) {}

    public function getAll(): array {
        $contexts = $this->cRepo->findAll();
        return array_map(fn(Context $c) => $this->toDto($c), $contexts);

    }
    public function toDto(Context $c): ContextDTO {
        return new ContextDTO($c->getId(), $c->getName());
    }
}