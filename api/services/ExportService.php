<?php


class ExportService {
    public function __construct(
        private GiftRepository $giftRepo,
        private CategoryRepository $catRepo,
        private ReportFactory $repoFact
    ) {}
    public function exportGifts(string $format):RawResponse {
        $gifts = $this->giftRepo->findAllExport();

        $rows = array_map(function (Gift $g) {
            return [
                'id'              => $g->getId(),
                'name'            => $g->getName(),
                'description'     => $g->getDescription(),
                'price'           => $g->getPrice(),
                'category_id'     => $g->getCategoryId(),
                'brand_id'        => $g->getBrandId(),
                'image_url'       => $g->getImageUrl(),
                'specifications'  => json_encode($g->getSpecifications() ?? new stdClass()),
                'tag_ids'         => implode(',', array_map(fn(Tag $t) => $t->getId(), $g->getTags() ?? [])),
                'circumstance_ids' => implode(',', $g->getCircumstanceIds() ?? []),
                'context_ids'     => implode(',', $g->getContextIds() ?? []),
                'chosen_count'    => $g->getChosenCount(),
                'score'           => $g->getScore(),
                'created_at'      => $g->getCreatedAt(),
            ];
        }, $gifts);

        $data = new ReportData(
            title:       'Gifts Export',
            columns:     [
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'name', 'label' => 'Name'],
                ['key' => 'description', 'label' => 'Description'],
                ['key' => 'price', 'label' => 'Price'],
                ['key' => 'category_id', 'label' => 'Category ID'],
                ['key' => 'brand_id', 'label' => 'Brand ID'],
                ['key' => 'image_url', 'label' => 'Image URL'],
                ['key' => 'specifications', 'label' => 'Specifications'],
                ['key' => 'tag_ids', 'label' => 'Tag IDs'],
                ['key' => 'circumstance_ids', 'label' => 'Circumstance IDs'],
                ['key' => 'context_ids', 'label' => 'Context IDs'],
                ['key' => 'chosen_count', 'label' => 'Chosen Count'],
                ['key' => 'score', 'label' => 'Score'],
                ['key' => 'created_at', 'label' => 'Created At'],
            ],
            rows:        $rows,
            summary:     ['total' => count($rows)],
            filters:     [],
            generatedAt: date('Y-m-d H:i:s'),
        );
        $generator = $this->repoFact->create($format);
        $body = $generator->generate($data);
        $filename = 'gifts-export-' . date('Ymd-His') . '.' . $generator->getFileExtension();
        return new RawResponse($body, $generator->getContentType(), $filename);
    }

    public function exportCategories(string $format) : RawResponse{
        $categories = $this->catRepo->findAll(activeOnly: false);
        
        $rows = array_map(fn(Category $c) => [
            'id'           => $c->getId(),
            'name'         => $c->getName(),
            'description'  => $c->getDescription(),
            'image_url'    => $c->getImageUrl(),
            'is_active'    => $c->getIsActive() ? 1 : 0,
            'sort_order'   => $c->getSortOrder(),
            'created_at'   => $c->getCreatedAt(),
        ], $categories);

        $data = new ReportData(
            title:       'Categories Export',
            columns:     [
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'name', 'label' => 'Name'],
                ['key' => 'description', 'label' => 'Description'],
                ['key' => 'image_url', 'label' => 'Image URL'],
                ['key' => 'is_active', 'label' => 'Active'],
                ['key' => 'sort_order', 'label' => 'Sort Order'],
                ['key' => 'created_at', 'label' => 'Created At'],
            ],
            rows:        $rows,
            summary:     ['total' => count($rows)],
            filters:     [],
            generatedAt: date('Y-m-d H:i:s'),
        );

        $generator = $this->repoFact->create($format);
        $body = $generator->generate($data);
        $filename = 'categories-export-' . date('Ymd-His') . '.' . $generator->getFileExtension();

        return new RawResponse($body, $generator->getContentType(), $filename);

    }
}