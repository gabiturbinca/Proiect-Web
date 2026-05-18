<?php

class GiftService {
    private GiftRepository $giftRepository;

    public function __construct(GiftRepository $giftRepository) {
        $this->giftRepository = $giftRepository;
    }
    public function getGiftsByCategoryId($categoryId, $elemNumber, $pageNumber) {
        $offset = ($pageNumber - 1) * $elemNumber;
        return [
            'gifts' => array_map(fn(Gift $g) => new GiftDTO($g->getId(), $g->getName(),$g->getDescription(), $g->getPrice(), $g->getImageUrl(), $g->getBrandName(), $g->getCategoryName(), $g->getTagDtos()) ,$this->giftRepository->findAllByCategory($categoryId, $elemNumber, $offset)),
            'gifts_count' => $this->giftRepository->getGiftsCountByCategory($categoryId)
        ];  
    }

    public function getGiftById($id) {
        $gift = $this->giftRepository->findById($id);
        return new GiftDTO($gift->getId(),$gift->getName(), $gift->getDescription(), $gift->getPrice(), $gift->getImageUrl(), $gift->getBrandName(), $gift->getCategoryName(), $gift->getTagDtos());
    }

    public function getAllGifts($elemNumber, $pageNumber) {
        $offset = ($pageNumber - 1) * $elemNumber;
        return [
            'gifts' => array_map(fn(Gift $g) => new GiftDTO($g->getId(), $g->getName(),$g->getDescription(), $g->getPrice(), $g->getImageUrl(), $g->getBrandName(), $g->getCategoryName(), $g->getTagDtos()) ,$this->giftRepository->findAll($elemNumber, $offset)),
            'gifts_count' => $this->giftRepository->getGiftsCount()
        ];
    }

}