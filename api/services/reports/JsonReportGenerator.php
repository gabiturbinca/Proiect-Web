<?php


class JsonReportGenerator implements ReportGenerator {
    public function generate(ReportData $data):string {
        return json_encode([
            'title'        => $data->title,
        'generated_at' => $data->generatedAt,
        'filters'      => $data->filters,
        'columns'      => $data->columns,
        'rows'         => $data->rows,
        'summary'      => $data->summary,
    ], JSON_PRETTY_PRINT);

    }
    public function getContentType():string {
        return 'application/json';
    }
    public function getFileExtension():string {
        return 'json';
    }
    
}