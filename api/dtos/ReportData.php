<?php


readonly class ReportData {
    public function __construct(
        public string $title,
        public array $columns,
        public array $rows,
        public array $summary,
        public array $filters,
        public string $generatedAt
    ) {}
}