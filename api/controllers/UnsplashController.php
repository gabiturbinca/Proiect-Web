<?php


class UnsplashController {

    public function __construct(private UnsplashService $uService) {}
    public function search() : array {
        $elemNumber = (int) ($_GET['elemNumber'] ?? 10);
        $elemNumber = max(1,min($elemNumber, 30));

        $query = (string ) trim($_GET['query'] ?? '');
        if($query === '') {
            throw new ValidationException(['query' => ['Query parameter is not set']]);
        }
        return ['images' => $this->uService->search($query, $elemNumber)];
    }
}