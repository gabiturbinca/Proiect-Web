<?php

class GiftService {
    private GiftRepository $giftRepository;

    public function __construct(GiftRepository $giftRepository) {
        $this->giftRepository = $giftRepository;
    }
    public function getGiftsByCategoryId($categoryId, $elemNumber, $pageNumber) {
        $offset = ($pageNumber - 1) * $elemNumber;
        return $this->giftRepository->findAllByCategory($categoryId, $elemNumber, $offset);
    }

    public function getGiftById($id) {
        return $this->giftRepository->findById($id);
    }

    public function getAllGifts($elemNumber, $pageNumber) {
        $offset = ($pageNumber - 1) * $elemNumber;
        return $this->giftRepository->findAll($elemNumber, $offset);
    }

}