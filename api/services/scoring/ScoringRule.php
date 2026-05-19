<?php

interface ScoringRule {
    public function score(Gift $gift, RecommendationRequestDTO $req) :int;
}