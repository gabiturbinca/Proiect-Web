<?php

class RecommendationController {
    public function __construct(private RecommendationService $recService) {}

    public function recommend(): array {
    $req = new RecommendationRequestDTO(
        categoryId:     isset($_GET['category'])     ? (int)   $_GET['category']     : null,
        brandId:        isset($_GET['brand'])        ? (int)   $_GET['brand']        : null,
        circumstanceId: isset($_GET['circumstance']) ? (int)   $_GET['circumstance'] : null,
        contextId:      isset($_GET['context'])      ? (int)   $_GET['context']      : null,
        budgetMin:      isset($_GET['budget_min'])   ? (float) $_GET['budget_min']   : null,
        budgetMax:      isset($_GET['budget_max'])   ? (float) $_GET['budget_max']   : null,
        tagIds:         isset($_GET['tags']) ? array_map('intval', explode(',', $_GET['tags'])) : [],
        limit:          max(1, min(100, (int) ($_GET['limit'] ?? 20))),
        page:           max(1, (int) ($_GET['page'] ?? 1)),
    );
    return $this->recService->recommend($req);
    }

}