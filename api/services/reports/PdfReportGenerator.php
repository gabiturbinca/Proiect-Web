<?php

use Dompdf\Dompdf;

class PdfReportGenerator implements ReportGenerator {
    public function __construct(private HtmlReportGenerator $htmlGenerator) {}
    public function generate(ReportData $data):string
    {
        $html = $this->htmlGenerator->generate($data);
        
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        return $dompdf->output();
    }
    public function getContentType():string {
        return 'application/pdf';
    }
    public function getFileExtension():string {
        return 'pdf';
    }
    
}