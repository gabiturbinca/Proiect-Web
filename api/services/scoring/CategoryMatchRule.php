<?php

class CategoryMatchRule implements ScoringRule {

    public function score(Gift $gift, RecommendationRequestDTO $req): int
    {
        if($req->categoryId === null)
             return 0;
        return $gift->getCategoryId() === $req->categoryId ? 5 : 0;
    }
}