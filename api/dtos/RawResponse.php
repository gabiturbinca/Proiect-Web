<?php


class RawResponse {
    
    public function __construct(
        public string $body,
        public string $type,
        public string $filename
    ) {}
    public function send(): void {
    header('Content-Type: ' . $this->type);
    if ($this->filename !== '') {
        header('Content-Disposition: attachment; filename="' . $this->filename . '"');
    }
    echo $this->body;
}
}