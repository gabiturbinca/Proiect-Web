<?php

class CategoryService {
    private CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository) {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategories($activeOnly = true) {
        return array_map(fn(Category $c) => new CategoryDTO($c->getId(), $c->getName(), $c->getDescription(), $c->getImageUrl()), $this->categoryRepository->findAll($activeOnly));
    }

    public function getCategoryById($id, $activeOnly = true) {
        $category = $this->categoryRepository->findById($id, $activeOnly);
        return new CategoryDTO($category->getId(), $category->getName(), $category->getDescription(), $category->getImageUrl());
    }

    public function getIdNameCategories($activeOnly = true) {
        return array_map(fn(Category $c) => new IdNameCategoryDTO($c->getId(), $c->getName()), $this->categoryRepository->findAll($activeOnly));
    }

    public function create(CategoryRequestDTO $dto): CategoryDTO {
        if ($dto->name === null) {
            throw new ValidationException(['name' => ['Name is required']]);
        }
        if ($this->categoryRepository->existsByName($dto->name)) {
            throw new ConflictException(['name' => ['Category name already exists']]);
        }

        $cat = new Category();
        $cat->setName($dto->name);
        $cat->setDescription($dto->description);
        $cat->setImageUrl($dto->imageUrl);
        $cat->setIsActive($dto->isActive ?? true);
        $cat->setSortOrder($dto->sortOrder ?? 0);

        $cat = $this->categoryRepository->create($cat);
        return new CategoryDTO($cat->getId(), $cat->getName(), $cat->getDescription(), $cat->getImageUrl());
    }

    public function update(int $id, CategoryRequestDTO $dto): CategoryDTO {
        $existing = $this->categoryRepository->findById($id, false);

        if ($dto->name !== null && $dto->name !== $existing->getName()) {
            if ($this->categoryRepository->existsByName($dto->name, $id)) {
                throw new ConflictException(['name' => ['Category name already exists']]);
            }
        }

        $fields = [];
        if ($dto->name !== null)        $fields['name'] = $dto->name;
        if ($dto->description !== null) $fields['description'] = $dto->description;
        if ($dto->imageUrl !== null)    $fields['image_url'] = $dto->imageUrl;
        if ($dto->isActive !== null)    $fields['is_active'] = $dto->isActive;
        if ($dto->sortOrder !== null)   $fields['sort_order'] = $dto->sortOrder;

        $this->categoryRepository->update($id, $fields);
        $updated = $this->categoryRepository->findById($id, false);
        return new CategoryDTO($updated->getId(), $updated->getName(), $updated->getDescription(), $updated->getImageUrl());
    }

    public function delete(int $id): void {
        $this->categoryRepository->findById($id, false);
        $this->categoryRepository->delete($id);
    }
}
