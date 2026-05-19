<?php


class Review {
    private int $id;
    private int $gift_id;
    private int $user_id;
    private float $rating;
    private ?string $comment;
    private string $created_at;
    private string $giftName;
    private string $username;
    public function setUsername(string $username): void {
        $this->username = $username;
    }
    public function getUsername(): string {
        return $this->username;
    }
    public function setGiftName(string $giftName): void {
        $this->giftName = $giftName;
    }
    public function getGiftName(): string {
        return $this->giftName;
    }
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function setGiftId(int $gift_id): void {
        $this->gift_id = $gift_id;
    }
    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }
    public function setComment(?string $comment): void {
        $this->comment = $comment;
    }
    public function setCreatedAt(string $created_at): void {
        $this->created_at = $created_at;
    }
    public function getId(): int {
        return $this->id;
    }
    public function setRating(float $rating): void {
        $this->rating = $rating;
    }
    public function getGiftId(): int {
        return $this->gift_id;
    }
    public function getUserId(): int {
        return $this->user_id;
    }
    public function getComment(): ?string {
        return $this->comment;
    }
    public function getCreatedAt(): string {
        return $this->created_at;
    }
    public function getRating():float{
        return $this->rating;
    }
}