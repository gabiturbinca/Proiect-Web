<?php

class Category {
    public int $id;
    public string $name;
    public ?string $description;
    public ?string $image_url;
    public bool $is_active;
    public int $sort_order;
    public string $created_at;
}
