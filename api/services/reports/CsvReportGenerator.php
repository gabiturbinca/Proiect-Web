<?php

class CsvReportGenerator implements ReportGenerator {
    public function generate(ReportData $data):string {
        $out = fopen('php://temp', 'r+');
        fwrite($out, "\xEF\xBB\xBF");
        fputcsv($out, array_column($data->columns, 'label'));
        foreach ($data->rows as $row) {
            $line = array_map(fn($col) => $row[$col['key']] ?? '', $data->columns);
            fputcsv($out, $line);
        }

        rewind($out);
        return stream_get_contents($out);
    }
    public function getContentType():string{
        return 'text/csv';
    }
    public function getFileExtension():string {
        return 'csv';
    }
}