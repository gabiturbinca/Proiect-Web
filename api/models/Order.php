<?php


class Order {
    private int $id;
    public function setId(int $id): void {
        $this->id = $id;
    }
    public function getId(): int {
        return $this->id;
    }
    private int $user_id;
    public function setUserId(int $user_id): void {
        $this->user_id = $user_id;
    }
    public function getUserId(): int {
        return $this->user_id;
    }
    private int $gift_id;
    public function setGiftId(int $gift_id): void {
        $this->gift_id = $gift_id;
    }
    public function getGiftId(): int {
        return $this->gift_id;
    }
    private int $quantity;
    public function setQuantity(int $quantity): void {
        $this->quantity = $quantity;
    }
    public function getQuantity(): int {
        return $this->quantity;
    }
    private float $total_price;
    public function setTotalPrice(float $total_price): void {
        $this->total_price = $total_price;
    }
    public function getTotalPrice(): float{
        return $this->total_price;
    }
    private string $status;
    public function setStatus(string $status): void {
        $this->status = $status;
    }
    public function getStatus(): string {
        return $this->status;
    }
    private string $created_at;
    public function setCreatedAt(string $created_at): void {
        $this->created_at = $created_at;
    }
    public function getCreatedAt(): string {
        return $this->created_at;
    }
    private string $last_updated;
    public function setLastUpdated(string $last_updated): void {
        $this->last_updated = $last_updated;
    }
    public function getLastUpdated(): string {
        return $this->last_updated;
    }
    private string $address;
    public function setAddress(string $address): void {
        $this->address = $address;
    }
    public function getAddress(): string {
        return $this->address;
    }
    private bool $is_anonymous;
    public function setIsAnonymous(bool $is_anonymous): void {
        $this->is_anonymous = $is_anonymous;
    }
    public function getIsAnonymous(): bool {
        return $this->is_anonymous;
    }
    private ?string $description;
    public function setDescription(?string $description): void {
        $this->description = $description;
    }
    public function getDescription(): ?string {
        return $this->description;
    }
    private ?string $recipient_name;
    public function setRecipientName(?string $recipient_name): void {
        $this->recipient_name = $recipient_name;
    }
    public function getRecipientName(): ?string {
        return $this->recipient_name;
    }
    private ?string $gift_name = null;
    public function setGiftName(?string $gift_name): void {
        $this->gift_name = $gift_name;
    }
    public function getGiftName(): ?string {
        return $this->gift_name;
    }
    private ?float $gift_price = null;
    public function setGiftPrice(?float $gift_price): void {
        $this->gift_price = $gift_price;
    }
    public function getGiftPrice(): ?float{
        return $this->gift_price;
    }
    private ?string $username = null; 
    public function setUsername(?string $username): void {
        $this->username = $username;
    }
    public function getUsername(): ?string {
        return $this->username;
    }
}