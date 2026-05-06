<?php

class Tag {
    private int $id;
    private string $name;
    private string $slug;

    public function setId(int $id) {
        $this->id = $id;
    }
    public function getId(): int {
        return $this->id;
    }
    public function getName(): string {
        return $this->name;
    }
    public function setName(string $name) {
        $this->name = $name;
    }
    public function getSlug(): string {
        return $this->slug;
    }
    public function setSlug(string $slug) {
        $this->slug = $slug;
    }

}
