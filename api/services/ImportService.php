<?php


class ImportService {

    public function __construct(
        private CategoryRepository $catRepo,
        private GiftRepository $giftRepo
    ) {}

    public function importCategories(string $format) : array {
        return [];
    }
    public function importGifts(string $format) : array {
        return [];
    }
}