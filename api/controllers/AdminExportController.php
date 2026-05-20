<?php


class AdminExportController {

    public function __construct(
        private ExportService $expService,
    ){}

    public function gifts() : RawResponse{
        $format = $_GET['format'] ?? 'json';
        if (!in_array($format, ['csv', 'json'], true)) {
            throw new ValidationException(['format' => ['Only csv and json supported for export']]);
        }
        return $this->expService->exportGifts($format);
    }

    public function categories() :RawResponse{
        $format = $_GET['format'] ?? 'json';
        if (!in_array($format, ['csv', 'json'], true)) {
            throw new ValidationException(['format' => ['Only csv and json supported for export']]);
        }
        return $this->expService->exportCategories($format);

    }
}