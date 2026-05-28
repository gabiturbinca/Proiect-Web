<?php


class RatingBonusRule implements ScoringRule {
    public function score(Gift $g, RecommendationRequestDTO $req): int {
        return (int) round($g->getScore());
    }
}
