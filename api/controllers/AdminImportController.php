<?php


class AdminImportController {

    public function __construct(
        private ImportService $impService,
    ){}

    public function gifts(): array {
        $format = $_GET['format'] ?? 'json';
        if (!in_array($format, ['csv', 'json'], true)) {
            throw new ValidationException(['format' => ['Only csv and json supported for import']]);
        }
        return $this->impService->importGifts($format);
    }

    public function categories() : array {
        $format = $_GET['format'] ?? 'json';
        if (!in_array($format, ['csv', 'json'], true)) {
            throw new ValidationException(['format' => ['Only csv and json supported for import']]);
        }
        return $this->impService->importCategories($format);
    }
}