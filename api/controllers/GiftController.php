<?php

class GiftController {
    private GiftService $giftService;

    public function __construct(GiftService $giftService) {
        $this->giftService = $giftService;
    }

    public function show($id) : array {
        return $this->giftService->getGiftById($id);
    }

    public function list() : array {
        $elemNumber = (int)($_GET['elemNumber'] ?? 10);
        $pageNumber = (int)($_GET['pageNumber'] ?? 1);
        return $this->giftService->getAllGifts($elemNumber, $pageNumber);
    }

    public function listByCategory($categoryId) : array {
        $elemNumber = (int)($_GET['elemNumber'] ?? 10);
        $pageNumber = (int)($_GET['pageNumber'] ?? 1);
        return $this->giftService->getGiftsByCategoryId($categoryId, $elemNumber, $pageNumber);
    }
}