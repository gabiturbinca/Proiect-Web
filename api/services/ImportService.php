<?php


class ImportService {

    public function __construct(
        private CategoryService $catService,
        private GiftService $giftService
    ) {}

    public function importCategories(string $format, string $contents): ImportResultDTO {
        $rows = $this->parseInput($format, $contents);
        
        $total = count($rows);
        $imported = 0;
        $errors = [];
        
        foreach ($rows as $index => $row) {
            try {
                $data = Validator::make($row, CategoryRequestDTO::RULES_CREATE)->validate();
                $dto = new CategoryRequestDTO(
                    name:        $data['name'],
                    description: $data['description'] ?? null,
                    imageUrl:    $data['image_url'] ?? null,
                    isActive:    filter_var($row['is_active'], FILTER_VALIDATE_BOOLEAN),
                    sortOrder:   isset($row['sort_order']) ? (int) $row['sort_order'] : null,
                );
                $this->catService->create($dto);
                $imported++;
            } catch (ValidationException $e) {
                $errors[$index] = array_merge(...array_values($e->getErrors()));
            } catch (ConflictException $e) {
                $errors[$index] = ['Category name already exists'];
            } catch (Throwable $e) {
                $errors[$index] = [$e->getMessage()];
            }
        }
    
        return new ImportResultDTO($total, $imported, $total - $imported, $errors);
    }

    public function importGifts(string $format, string $contents) : ImportResultDTO {
        $rows = $this->parseInput($format, $contents);

        $total = count($rows);
        $imported = 0;
        $errors = [];
        foreach ($rows as $index => $row) {
            try {
                $normal = $this->normalGiftRow($row);
                $data = Validator::make($normal, CreateGiftRequestDTO::RULES)->validate();
                $dto = new CreateGiftRequestDTO(
                name:            $data['name'],
                description:     $data['description'] ?? null,
                price:           (float) $data['price'],
                categoryId:      (int) $data['category_id'],
                brandId:         isset($data['brand_id']) ? (int) $data['brand_id'] : null,
                specifications:  $normal['specifications'] ?? null,
                tagIds:          $normal['tag_ids'] ?? [],
                circumstanceIds: $normal['circumstance_ids'] ?? [],
                contextIds:      $normal['context_ids'] ?? [],
            );
            
            $this->giftService->create($dto);
            $imported++;
            } catch (ValidationException $e) {
                $errors[$index] = array_merge(...array_values($e->getErrors()));
            } catch (Throwable $e) {
                $errors[$index] = [$e->getMessage()];
            }
        }
        return new ImportResultDTO($total, $imported, $total - $imported, $errors);
    }
    private function parseInput(string $format, string $contents): array {
        if ($format === 'json') {
            $data = json_decode($contents, true);
            if (!is_array($data)) {
                throw new ValidationException(['file' => ['Invalid JSON']]);
            }
            return $data;
        }
        $contents = ltrim($contents, "\xEF\xBB\xBF");
        $lines = preg_split('/\r\n|\r|\n/', trim($contents));
        //endlineuri pe orice sistem
        $rows = [];
        $headers = null;
        foreach ($lines as $line) {
            if ($line === '') continue;
            $cells = str_getcsv($line);
            if ($headers === null) {
                $headers = $cells;
                continue;
            }
            $rows[] = array_combine($headers, $cells);
        }
        return $rows;
    }
    private function normalGiftRow(array $row): array {
        foreach (['tag_ids', 'circumstance_ids', 'context_ids'] as $key) {
            if (isset($row[$key])) {
                if (is_string($row[$key])) {
                    $row[$key] = $row[$key] === ''
                        ? []
                        : array_map('intval', explode(',', $row[$key]));
                } elseif (is_array($row[$key])) {
                    $row[$key] = array_map('intval', $row[$key]);
                }
            }
        }
    
    // specifications: json sau array
        if (isset($row['specifications']) && is_string($row['specifications'])) {
            $row['specifications'] = $row['specifications'] === ''
                ? null
                : json_decode($row['specifications'], true);
        }
        return $row;
    }

}