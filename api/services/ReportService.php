<?php


class ReportService {

    public function __construct(
        private ReportRepository $repoRepo,
        private ReportFactory $repoFact
    ) {}

    public function generate(string $type,
    string $format,
    ?string $from,
    ?string $to,
    ?int $category) : RawResponse {
        $result = match($type) {
            'orders' => $this->buildOrdersReport($from, $to, $category),
            'categories' => $this->buildCategoryReport($from, $to),
            'users' => $this->buildUsersReport($from, $to),
            default => throw new ValidationException(['type' => ["Unknown type : $type "]]),
        };

        $generator = $this->repoFact->create($format);
        $body = $generator->generate($result);

        $filename = "report-{$type}-" . date('Ymd-His') . '.' . $generator->getFileExtension();

        return new RawResponse($body, $generator->getContentType(), $filename);

    }
    private function buildOrdersReport(?string $from, ?string $to, ?int $categoryId): ReportData {
        $rows = $this->repoRepo->fetchOrdersReport($from, $to, $categoryId);
        
        return new ReportData(
            title:       'Orders Report',
            columns:     [
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'gift_name', 'label' => 'Gift'],
                ['key' => 'username', 'label' => 'User'],
                ['key' => 'quantity', 'label' => 'Quantity'],
                ['key' => 'total_price', 'label' => 'Total'],
                ['key' => 'status', 'label' => 'Status'],
                ['key' => 'created_at', 'label' => 'Date'],
            ],
            rows:        $rows,
            summary:     [
                'total_orders'  => count($rows),
                'total_revenue' => array_sum(array_column(
                array_filter($rows, fn($r) => $r['status'] !== 'cancelled'),
                'total_price')),
            ],
            filters:     ['from' => $from, 'to' => $to, 'category_id' => $categoryId],
            generatedAt: date('Y-m-d H:i:s'),
        );
    }

    private function buildUsersReport(?string $from, ?string $to) :ReportData {
        $rows = $this->repoRepo->fetchUsersReport($from, $to);

        return new ReportData(
            title : 'Users report',
            columns : [
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'username', 'label' => 'User'],
                ['key' => 'email', 'label' => 'Email'],
                ['key' => 'order_number', 'label' => 'Number of orders'],
                ['key' => 'total_spent', 'label' => 'Spendings']
            ],
            rows : $rows,
            summary: [
                'total_users' => count($rows),
            ],
            filters: ['from' => $from, 'to' => $to],
            generatedAt: date('Y-m-d H:i:s'),
        );
    }

    private function buildCategoryReport(?string $from, ?string $to) : ReportData {
        $rows = $this->repoRepo->fetchCategoriesReport($from, $to);
        return new ReportData(
            title: 'Categories report',
            columns: [
                ['key' => 'id', 'label' => 'ID'],
                ['key' => 'category_name', 'label' => 'Category'],
                ['key' => 'total_revenue', 'label' => 'Revenue'],
            ],
            rows: $rows,
            summary: [
                'total_categories' => count($rows)
            ],
            filters: ['from' => $from, 'to' => $to],
            generatedAt: date('Y-m-d H:i:s'),
        );
    }
}