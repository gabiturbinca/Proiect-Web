<?php

class Scorer {
    public function __construct(private array $rules) {}
    
    public function score(Gift $g, RecommendationRequestDTO $req): int {
        return array_sum(array_map(
            fn(ScoringRule $r) => $r->score($g, $req),
            $this->rules,
        ));
    }
}
