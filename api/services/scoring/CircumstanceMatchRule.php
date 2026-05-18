<?php


class CircumstanceMatchRule implements ScoringRule {

    public function score(Gift $gift, RecommendationRequestDTO $req): int
    {
        if($req->circumstanceId === null)
             return 0;
        return in_array($req->circumstanceId, $gift->getCircumstanceIds() ?? [], true) ? 3 :0;
    }
}