<?php


class Context {
    private int $id;
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function getId(): int {
        return $this->id;
    }
    private string $name;
    public function setName(string $name): void {
        $this->name = $name;
    }
    public function getName(): string {
        return $this->name;
    }
    private ?string $description;
    public function setDescription(?string $description): void {
        $this->description = $description;
    }
    public function getDescription(): ?string {
        return $this->description;
    }

}