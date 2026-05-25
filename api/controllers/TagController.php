<?php

class TagController {
    private TagService $tagService;
    public function __construct(TagService $tagService) {
        $this->tagService = $tagService;
    }

    public function index() : array {
        return $this->tagService->getAllTags();
    }
}