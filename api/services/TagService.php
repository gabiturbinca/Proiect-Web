<?php

class TagService {

    private TagRepository $tagRepository;
    public function __construct(TagRepository $tagRepository) {
        $this->tagRepository = $tagRepository;
    }

    public function getAllTags() {
        return array_map(fn(Tag $tag) => new TagDTO($tag->getId(), $tag->getName(), $tag->getSlug()),$this->tagRepository->findAll());
    }
    
}