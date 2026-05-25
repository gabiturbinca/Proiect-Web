<?php


class ExportService {
    public function __construct(
        private GiftRepository $giftRepo,
        private CategoryRepository $catRepo,
    ) {}

    public function exportGifts(string $format): RawResponse {
        $gifts = $this->giftRepo->findAllExport();

        $rows = array_map(function (Gift $g) {
            return [
                'id'               => $g->getId(),
                'name'             => $g->getName(),
                'description'      => $g->getDescription(),
                'price'            => $g->getPrice(),
                'category_id'      => $g->getCategoryId(),
                'brand_id'         => $g->getBrandId(),
                'image_url'        => $g->getImageUrl(),
                'specifications'   => json_encode($g->getSpecifications() ?? new stdClass()),
                'tag_ids'          => implode(',', array_map(fn(Tag $t) => $t->getId(), $g->getTags() ?? [])),
                'circumstance_ids' => implode(',', $g->getCircumstanceIds() ?? []),
                'context_ids'      => implode(',', $g->getContextIds() ?? []),
                'chosen_count'     => $g->getChosenCount(),
                'score'            => $g->getScore(),
                'created_at'       => $g->getCreatedAt(),
            ];
        }, $gifts);

        return $this->buildResponse('gifts', $format, $rows);
    }

    public function exportCategories(string $format): RawResponse {
        $categories = $this->catRepo->findAll(activeOnly: false);

        $rows = array_map(fn(Category $c) => [
            'id'          => $c->getId(),
            'name'        => $c->getName(),
            'description' => $c->getDescription(),
            'image_url'   => $c->getImageUrl(),
            'is_active'   => $c->getIsActive() ? 1 : 0,
            'sort_order'  => $c->getSortOrder(),
            'created_at'  => $c->getCreatedAt(),
        ], $categories);

        return $this->buildResponse('categories', $format, $rows);
    }

    private function buildResponse(string $entity, string $format, array $rows): RawResponse {
        $body = match ($format) {
            'json' => json_encode($rows, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            'csv'  => $this->arrayToCsv($rows),
            default => throw new ValidationException(['format' => ["Unsupported format: $format"]]),
        };

        $contentType = $format === 'json' ? 'application/json' : 'text/csv';
        $filename = "$entity-export-" . date('Ymd-His') . ".$format";

        return new RawResponse($body, $contentType, $filename);
    }

    private function arrayToCsv(array $rows): string {
        $out = fopen('php://temp', 'r+');
        fwrite($out, "\xEF\xBB\xBF");

        if (empty($rows)) {
            rewind($out);
            return stream_get_contents($out);
        }

        fputcsv($out, array_keys($rows[0]));
        foreach ($rows as $row) {
            fputcsv($out, array_values($row));
        }

        rewind($out);
        return stream_get_contents($out);
    }
}
