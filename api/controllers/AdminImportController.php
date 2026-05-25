<?php


class AdminImportController {

    public function __construct(
        private ImportService $impService,
    ){}

    public function gifts(): ImportResultDTO {
    $format = $_GET['format'] ?? 'json';
    if (!in_array($format, ['csv', 'json'], true)) {
        throw new ValidationException(['format' => ['Only csv and json supported']]);
    }
    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        throw new ValidationException(['file' => ['Upload failed']]);
    }
    $contents = file_get_contents($_FILES['file']['tmp_name']);
    return $this->impService->importGifts($format, $contents);
}

    public function categories() : ImportResultDTO {
        $format = $_GET['format'] ?? 'json';
        if (!in_array($format, ['csv', 'json'], true)) {
            throw new ValidationException(['format' => ['Only csv and json supported for import']]);
        }
        if(!isset($_FILES['file']) || $_FILES['file']['error'] !==UPLOAD_ERR_OK) {
            throw new ValidationException(['file' => ['Upload failed']]);
        }
        $contents = file_get_contents($_FILES['file']['tmp_name']);
        return $this->impService->importCategories($format, $contents);
    }
}