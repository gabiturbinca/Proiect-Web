<?php

class TagOverlapRule implements ScoringRule {

    public function score(Gift $gift, RecommendationRequestDTO $req): int
    {
        if(empty($req->tagIds) || empty($gift->getTags()))
            return 0;
        $giftTagIds = array_map(fn(Tag $t) => $t->getId(), $gift->getTags());
        return count(array_intersect($giftTagIds, $req->tagIds)) * 2;
    }
}