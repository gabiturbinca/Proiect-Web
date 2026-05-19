<?php

class CategoryController {
    public function __construct(private CategoryService $categoryService) {}

    public function index(): array {
        $activeOnly = isset($_GET['activeOnly']) ? filter_var($_GET['activeOnly'], FILTER_VALIDATE_BOOLEAN) : true;
        return $this->categoryService->getAllCategories($activeOnly);
    }

    public function show($id): CategoryDTO {
        return $this->categoryService->getCategoryById($id);
    }

    public function indexShort(): array {
        $activeOnly = isset($_GET['activeOnly']) ? filter_var($_GET['activeOnly'], FILTER_VALIDATE_BOOLEAN) : true;
        return $this->categoryService->getAllCategories($activeOnly);
    }

    public function create(): CategoryDTO {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        $data = Validator::make($input, CategoryRequestDTO::RULES_CREATE)->validate();
        $dto = $this->buildDTO($data);
        return $this->categoryService->create($dto);
    }

    public function update(int $id): CategoryDTO {
        $input = json_decode(file_get_contents('php://input'), true) ?? [];
        Validator::make($input, CategoryRequestDTO::RULES_UPDATE)->validate();
        $dto = $this->buildDTO($input);
        return $this->categoryService->update($id, $dto);
    }

    public function delete(int $id): array {
        $this->categoryService->delete($id);
        return ['message' => 'Category deleted'];
    }

    private function buildDTO(array $data): CategoryRequestDTO {
        return new CategoryRequestDTO(
            name:        $data['name'] ?? null,
            description: $data['description'] ?? null,
            imageUrl:    $data['image_url'] ?? null,
            isActive:    isset($data['is_active']) ? filter_var($data['is_active'], FILTER_VALIDATE_BOOLEAN) : null,
            sortOrder:   isset($data['sort_order']) ? (int) $data['sort_order'] : null,
        );
    }
}
