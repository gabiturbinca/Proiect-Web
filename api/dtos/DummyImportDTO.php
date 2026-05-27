<?php


class DummyImportDTO {
    public function __construct(
        public int $imported = 0,
        public int $skipped_dupes = 0,
        public int $skipped_invalid = 0,
        public int $brands_created = 0,
        public int $categories_created = 0,
     ) {}
}