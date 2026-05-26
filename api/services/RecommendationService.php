<?php


class RecommendationService {
    private Scorer $scorer;

    public function __construct(private GiftRepository $giftRepository) {
        $this->scorer = new Scorer([new BonusPopularityRule(),
        //new BrandMatchRule(),
        //new CategoryMatchRule(),
        new CircumstanceMatchRule(),
        new ContextMatchRule(),
        new TagOverlapRule(),
        ]);
    }

    public function recommend(RecommendationRequestDTO $req) : array {
        $allgifts = $this->giftRepository->findCandidates($req);
        $giftscores =array_map(
            fn(Gift $gift) => ['gift' => $gift,
            'score' => $this->scorer->score($gift, $req)], $allgifts
        );
        //sortare desc
        usort($giftscores, fn($a, $b) => $b['score'] <=> $a['score']);
        $offset = ($req->page -1) * $req->limit;
        $pagedGifts = array_slice($giftscores, $offset, $req->limit);
        return [
            'gifts' => array_map(
                fn($scoredgift) => new GiftDTO(
                    $scoredgift['gift']->getId(),
                    $scoredgift['gift']->getName(),
                    $scoredgift['gift']->getDescription(),
                    $scoredgift['gift']->getPrice(),
                    $scoredgift['gift']->getImageUrl(),
                    $scoredgift['gift']->getBrandName(),
                    $scoredgift['gift']->getCategoryName(),
                    $scoredgift['gift']->getTagDtos(),
                ),
                $pagedGifts,
            ),
            'gifts_count' => count($giftscores),
        ];
    }

}