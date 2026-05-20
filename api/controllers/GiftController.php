<?php

class GiftController {
    public function __construct(private GiftService $giftService) {}

    public function show($id): GiftDTO {
        return $this->giftService->getGiftById($id);
    }
    public function showRelated($id): array {
        $elemNumber = (int) ($_GET['elemNumber'] ?? 10);
        $pageNumber = (int) ($_GET['pageNumber'] ?? 1);
        return $this->giftService->getRelatedGiftsById($id, $elemNumber, $pageNumber);
    }
    public function index(): array {
        $elemNumber = (int) ($_GET['elemNumber'] ?? 10);
        $pageNumber = (int) ($_GET['pageNumber'] ?? 1);
        return $this->giftService->getAllGifts($elemNumber, $pageNumber);
    }

    public function indexByCategory($categoryId): array {
        $elemNumber = (int) ($_GET['elemNumber'] ?? 10);
        $pageNumber = (int) ($_GET['pageNumber'] ?? 1);
        return $this->giftService->getGiftsByCategoryId($categoryId, $elemNumber, $pageNumber);
    }

    public function create(): GiftDTO {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $data = Validator::make($input, CreateGiftRequestDTO::RULES)->validate();
        $dto = new CreateGiftRequestDTO(
            name:            $data['name'],
            description:     $data['description'] ?? null,
            price:           (float) $data['price'],
            categoryId:      (int) $data['category_id'],
            brandId:         isset($data['brand_id']) ? (int) $data['brand_id'] : null,
            specifications:  $data['specifications'] ?? null,
            tagIds:          $this->normalizeIntArray($data['tags'] ?? []),
            circumstanceIds: $this->normalizeIntArray($data['circumstances'] ?? []),
            contextIds:      $this->normalizeIntArray($data['contexts'] ?? []),
        );
        return $this->giftService->create($dto);
    }

    public function update(int $id): GiftDTO {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $data = Validator::make($input, UpdateGiftRequestDTO::RULES)->validate();
        $dto = new UpdateGiftRequestDTO(
            name:            $input['name'] ?? null,
            description:     $input['description'] ?? null,
            price:           isset($input['price']) ? (float) $input['price'] : null,
            categoryId:      isset($input['category_id']) ? (int) $input['category_id'] : null,
            brandId:         isset($input['brand_id']) ? (int) $input['brand_id'] : null,
            specifications:  $input['specifications'] ?? null,
            tagIds:          isset($input['tags']) ? $this->normalizeIntArray($input['tags']) : null,
            circumstanceIds: isset($input['circumstances']) ? $this->normalizeIntArray($input['circumstances']) : null,
            contextIds:      isset($input['contexts']) ? $this->normalizeIntArray($input['contexts']) : null,
        );
        return $this->giftService->update($id, $dto);
    }

    public function delete(int $id): array {
        $this->giftService->delete($id);
        return ['message' => 'Gift deleted'];
    }

    public function uploadImage(int $id): GiftDTO {
        if (!isset($_FILES['image'])) {
            throw new ValidationException(['image' => ['Image file is required']]);
        }
        return $this->giftService->uploadImage($id, $_FILES['image']);
    }

    public function deleteImage(int $id): GiftDTO {
        return $this->giftService->deleteImage($id);
    }

    private function normalizeIntArray(mixed $value): array {
        if (!is_array($value)) return [];
        return array_values(array_map('intval', $value));
    }
}
