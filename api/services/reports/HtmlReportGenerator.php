<?php


class HtmlReportGenerator implements ReportGenerator {
    public function generate(ReportData $data):string{
        //title
        $title = htmlspecialchars($data->title);
        //rows
        $allrows = [];
        foreach ($data->rows as $row) {
            $cells = array_map(
                fn($col) => '<td>' . htmlspecialchars($row[$col['key']] ?? '') . '</td>',
                $data->columns
            );
            $allrows[] = ' <tr> ' . implode('', $cells) . '</tr>';
        }
        $rowsHtml = implode('', $allrows);
        //header
        $headers = implode('', 
            array_map(fn($ch) => '<th>' . htmlspecialchars($ch['label']) .'</th>', $data->columns)
            );


        return <<<HTML
        <!DOCTYPE html>
        <head>
            <meta charset="UTF-8">
            <title>{$title}</title>
            <style>
            body { font-family: Arial, sans-serif; }
            table { border-collapse: collapse; width: 100%; }
            th, td { padding: 8px; border: 1px solid #09a466; text-align: left; }
            th { background: #ffffff; }
            @media print {
                body { font-size: 12pt; }
            }
            </style>
        </head>
        <body>
            <h1>{$title}</h1>
            <p>Generated: {$data->generatedAt} </p>
            <table>
                <thead><tr>{$headers}</tr></thead>
                <tbody>{$rowsHtml}</tbody>
            </table>
        </body>
        HTML;
    }
    public function getContentType():string{
        return 'text/html';
    }
    public function getFileExtension():string{
        return 'html';
    }
    
}