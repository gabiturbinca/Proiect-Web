<?php

class Category {
    private int $id;
    private string $name;
    private ?string $description;
    private ?string $image_url;
    private bool $is_active;
    private int $sort_order;
    private string $created_at;

    public function setId(int $id): void {
        $this->id = $id;
    }
    public function getId(): int {
        return $this->id;
    }
    public function setName(string $name): void {
        $this->name = $name;
    }
    public function getName(): string {
        return $this->name;
    }
    public function setDescription(?string $description): void {
        $this->description = $description;
    }
    public function getDescription(): ?string {
        return $this->description;
    }
    public function setImageUrl(?string $image_url): void {
        $this->image_url = $image_url;
    }
    public function getImageUrl(): ?string {
        return $this->image_url;
    }
    public function setIsActive(bool $is_active): void {
        $this->is_active = $is_active;
    }
    public function getIsActive(): bool {
        return $this->is_active;
    }
    public function setSortOrder(int $sort_order): void {
        $this->sort_order = $sort_order;
    }
    public function getSortOrder(): int {
        return $this->sort_order;
    }
    public function setCreatedAt(string $created_at): void {
        $this->created_at = $created_at;
    }
    public function getCreatedAt(): string {
        return $this->created_at;
    }
}
