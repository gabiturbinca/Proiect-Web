<?php

class GiftService {
    public function __construct(
        private GiftRepository $giftRepository,
        private ImageStorage $imageStorage,
    ) {}

    public function getGiftsByCategoryId($categoryId, $elemNumber, $pageNumber) {
        $offset = ($pageNumber - 1) * $elemNumber;
        return [
            'gifts' => array_map(fn(Gift $g) => $this->toDTO($g), $this->giftRepository->findAllByCategory($categoryId, $elemNumber, $offset)),
            'gifts_count' => $this->giftRepository->getGiftsCountByCategory($categoryId)
        ];
    }

    public function getGiftById($id) {
        $gift = $this->giftRepository->findById($id);
        return $this->toDTO($gift);
    }

    public function getAllGifts($elemNumber, $pageNumber) {
        $offset = ($pageNumber - 1) * $elemNumber;
        return [
            'gifts' => array_map(fn(Gift $g) => $this->toDTO($g), $this->giftRepository->findAll($elemNumber, $offset)),
            'gifts_count' => $this->giftRepository->getGiftsCount()
        ];
    }

    public function create(CreateGiftRequestDTO $dto): GiftDTO {
        $gift = new Gift();
        $gift->setName($dto->name);
        $gift->setDescription($dto->description);
        $gift->setPrice($dto->price);
        $gift->setCategoryId($dto->categoryId);
        $gift->setBrandId($dto->brandId);
        $gift->setSpecifications($dto->specifications);
        $gift->setImageUrl(null);

        $gift = $this->giftRepository->create($gift);

        $this->giftRepository->syncTags($gift->getId(), $dto->tagIds);
        $this->giftRepository->syncCircumstances($gift->getId(), $dto->circumstanceIds);
        $this->giftRepository->syncContexts($gift->getId(), $dto->contextIds);

        return $this->getGiftById($gift->getId());
    }

    public function update(int $id, UpdateGiftRequestDTO $dto): GiftDTO {
        $existing = $this->giftRepository->findByIdRaw($id);
        if ($existing === null) {
            throw new NotFoundException("Gift not found");
        }

        $fields = [];
        if ($dto->name !== null)           $fields['name'] = $dto->name;
        if ($dto->description !== null)    $fields['description'] = $dto->description;
        if ($dto->price !== null)          $fields['price'] = $dto->price;
        if ($dto->categoryId !== null)     $fields['category_id'] = $dto->categoryId;
        if ($dto->brandId !== null)        $fields['brand_id'] = $dto->brandId;
        if ($dto->specifications !== null) $fields['specifications'] = $dto->specifications;

        $this->giftRepository->update($id, $fields);

        if ($dto->tagIds !== null) {
            $this->giftRepository->syncTags($id, $dto->tagIds);
        }
        if ($dto->circumstanceIds !== null) {
            $this->giftRepository->syncCircumstances($id, $dto->circumstanceIds);
        }
        if ($dto->contextIds !== null) {
            $this->giftRepository->syncContexts($id, $dto->contextIds);
        }

        return $this->getGiftById($id);
    }

    public function delete(int $id): void {
        $existing = $this->giftRepository->findByIdRaw($id);
        if ($existing === null) {
            throw new NotFoundException("Gift not found");
        }
        $this->imageStorage->delete($existing->getImageUrl());
        $this->giftRepository->delete($id);
    }

    public function uploadImage(int $id, array $file): GiftDTO {
        $existing = $this->giftRepository->findByIdRaw($id);
        if ($existing === null) {
            throw new NotFoundException("Gift not found");
        }
        $this->imageStorage->delete($existing->getImageUrl());
        $url = $this->imageStorage->store($file, $id);
        $this->giftRepository->updateImageUrl($id, $url);
        return $this->getGiftById($id);
    }

    public function deleteImage(int $id): GiftDTO {
        $existing = $this->giftRepository->findByIdRaw($id);
        if ($existing === null) {
            throw new NotFoundException("Gift not found");
        }
        $this->imageStorage->delete($existing->getImageUrl());
        $this->giftRepository->updateImageUrl($id, null);
        return $this->getGiftById($id);
    }
    public function getRelatedGiftsById($id, $elemNumber, $pageNumber) : array {
        $offset = ($pageNumber - 1) * $elemNumber;
        return [
            'gifts' => array_map(fn(Gift $g) => $this->toDTO($g), $this->giftRepository->findRelated($id, $elemNumber, $offset)),
            'gifts_count' => $this->giftRepository->getRelatedCount($id),
        ];
    }

    private function toDTO(Gift $g): GiftDTO {
        return new GiftDTO(
            $g->getId(),
            $g->getName(),
            $g->getDescription(),
            $g->getPrice(),
            $g->getImageUrl(),
            $g->getBrandName(),
            $g->getCategoryName(),
            $g->getTagDtos(),
            $g->getCircumstanceIds(),
            $g->getContextIds(),
        );
    }
}
