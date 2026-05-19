<?php

class BrandMatchRule implements ScoringRule {

    public function score(Gift $gift, RecommendationRequestDTO $req): int
    {
        if($req->brandId === null)
             return 0;
        return $gift->getBrandId() === $req->brandId ? 4 : 0;
    }
}