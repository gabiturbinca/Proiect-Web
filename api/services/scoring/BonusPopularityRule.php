<?php


class BonusPopularityRule implements ScoringRule {
    public function score(Gift $g, RecommendationRequestDTO $req): int {
    return intdiv($g->getChosenCount(), 50); //+1 per 50
}
}