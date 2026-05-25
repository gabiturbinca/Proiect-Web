<?php

class Gift {
    private int $id;
    private string $name;
    private ?string $description;
    private float $price;
    private ?int $category_id;
    private ?array $specifications;
    private string $created_at;
    private ?int $brand_id;
    private ?string $image_url;
    private float $score;
    private int $chosen_count;
    private ?string $category_name = null;
    private ?string $brand_name = null;
    private ?array $tags = null;
    private ?array $circumstance_ids = null;
    private ?array $context_ids = null;

    public function getCircumstanceIds(): ?array { return $this->circumstance_ids; }
    public function setCircumstanceIds(?array $ids): void { $this->circumstance_ids = $ids; }
    public function getContextIds(): ?array { return $this->context_ids; }
    public function setContextIds(?array $ids): void { $this->context_ids = $ids; }

    public function getTags(): ?array {
        return $this->tags;
    }
    public function setTags(?array $tags): void {
        $this->tags = $tags;
    }
    public function addTag(string $tag): void {
        $this->tags[] = $tag;
    }
    public function getDescription(): ?string {
        return $this->description;
    }
    public function setDescription(?string $description): void {
        $this->description = $description;
    }
    public function getPrice(): float {
        return $this->price;
    }
    public function setPrice(float $price): void {
        $this->price = $price;
    }
    public function getCategoryId(): ?int {
        return $this->category_id;
    }
    public function setCategoryId(?int $category_id): void {
        $this->category_id = $category_id;
    }
    public function getSpecifications(): ?array {
        return $this->specifications;
    }
    public function setSpecifications(?array $specifications): void {
        $this->specifications = $specifications;
    }
    public function getCategoryName(): ?string {
        return $this->category_name;
    }

    public function setCategoryName(?string $category_name): void {
        $this->category_name = $category_name;
    }
    public function getScore(): float {
        return $this->score;
    }
    public function setScore(float $score): void {
        $this->score = (float)$score;
    }
    public function getId(): int {
        return $this->id;
    }
    public function setId(int $id): void {
        $this->id =(int) $id;
    }
    public function getName(): string {
        return $this->name;
    }
    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getBrandName(): ?string {
        return $this->brand_name;
    }

    public function setBrandName(?string $brand_name): void {
        $this->brand_name = $brand_name;
    }
    public function getChosenCount(): int {
        return $this->chosen_count;
    }
    public function setChosenCount(int $chosen_count): void {
        $this->chosen_count = $chosen_count;
    }
    public function getCreatedAt(): string {
        return $this->created_at;
    }
    public function setCreatedAt(string $created_at): void {
        $this->created_at = $created_at;
    }

    public function getImageUrl(): ?string {
        return $this->image_url;
    }
    public function setImageUrl(?string $image_url): void {
        $this->image_url = $image_url;
    }
    public function getBrandId(): ?int {
        return $this->brand_id;
    }
    public function setBrandId(?int $brand_id): void {
        $this->brand_id = $brand_id;
    }
    public function getTagDtos(): array {
    return array_map(
        fn(Tag $t) => new TagDTO($t->getId(), $t->getName(), $t->getSlug()),
        $this->tags ?? [],
    );
}
}
