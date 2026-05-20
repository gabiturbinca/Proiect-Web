<?php

class ReportFactory {

    public static function create(string $type) : ReportGenerator {
        $res = match($type) {
            'html' => new HtmlReportGenerator(),
            'pdf' => new PdfReportGenerator(new HtmlReportGenerator()),
            'json' => new JsonReportGenerator(),
            'csv' => new CsvReportGenerator(),
            default => null,
        };
        if($res === null ) {
            throw new ValidationException(['format' => ["Unknown format : $type"]]);
        }
        return $res;
    }

}