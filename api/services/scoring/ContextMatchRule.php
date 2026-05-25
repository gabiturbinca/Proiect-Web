<?php


class ContextMatchRule implements ScoringRule {

    public function score(Gift $gift, RecommendationRequestDTO $req): int
    {
        if($req->contextId === null)
             return 0;
        return in_array($req->contextId, $gift->getContextIds() ?? [], true) ? 3 :0;
    }
}