<?php

class Gift {
    public int $id;
    public string $name;
    public ?string $description;
    public string $price;
    public ?int $category_id;
    public ?array $specifications;
    public string $created_at;
    public ?int $brand_id;
    public ?string $image_url;
    public string $score;
    public int $chosen_count;
    public ?string $category_name = null;
    public ?string $brand_name = null;
    public ?array $tags = null;

    public function setTags(array $tags): void {
        $this->tags = $tags;
    }
}
