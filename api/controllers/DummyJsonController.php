<?php


class DummyJsonController {
    public function __construct(
        private DummyJsonService $dService
    ) {}

    public function import() : DummyImportDTO {
        $limit = (int) ($_GET['limit'] ?? 100);
        $skip = (int) ($_GET['skip'] ?? 0);
        return $this->dService->import($limit, $skip);
    }
}