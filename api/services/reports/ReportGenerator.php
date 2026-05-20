<?php


interface ReportGenerator {
    public function generate(ReportData $data):string;
    public function getContentType():string;//mime
    public function getFileExtension():string;
}