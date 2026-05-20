<?php


class AdminReportController {
    public function __construct(
        private ReportService $repoService
    ) {}

    public function generate() : RawResponse {
        $type = $_GET['type'] ?? 'orders';
        $format = $_GET['format'] ?? 'pdf';
        $from = $_GET['from'] ?? null;
        $to = $_GET['to'] ?? null;
        $category = isset($_GET['category']) ? (int) $_GET['category'] : null;

        return $this->repoService->generate($type, $format, $from, $to, $category);
    }
}