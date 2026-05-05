<?php

class TagService {

    private TagRepository $tagRepository;
    public function __construct(TagRepository $tagRepository) {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags() {
        return $this->tagRepository->findAll();
    }
    
}