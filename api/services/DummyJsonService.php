<?php



class DummyJsonService {

    public function __construct(
        private GiftRepository $gRepo,
        private BrandRepository $bRepo,
        private CategoryRepository $cRepo,
        private UnsplashService $unsplashService) {}

    private function fetchCategoryImage(string $categoryName): ?string {
        try {
            $images = $this->unsplashService->search($categoryName, 1);
            return $images[0]->urlFull ?? null;
        } catch (ExternalServiceException $e) {
            return null;
        }
    }
    public function fetchFromApi(int $limit, int $skip) : array {
        $url = "https://dummyjson.com/products?limit=$limit&skip=$skip";

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER , [
            'Accept-Version: v1'
        ]);

        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);
        if($response === false || $status >= 400) {
            throw new ExternalServiceException("Dummyjson API error: $error (status $status)");
        }
        
        $data = json_decode($response, true);

        if (!is_array($data['products'] ?? null)) 
            throw new ExternalServiceException("Invalid dummyjson response");
        return array_map(fn(array $item) => DummyJsonProductDTO::toDTO($item), $data['products']);
    }

    public function import(int $limit, int $skip) : DummyImportDTO {
        $data = $this->fetchFromApi($limit, $skip);
        $result = new DummyImportDTO();
        foreach($data as $dummyProductDto) {
            try {
            if($this->gRepo->existsByName($dummyProductDto->title))
                {
                    $result->skipped_dupes++;
                    continue;
                }
            $gift = new Gift();
            if($dummyProductDto->brand === null)
                $gift->setBrandId(null);
            else
            {
                $brand = $this->bRepo->findByName($dummyProductDto->brand);
                if($brand === null)
                    {
                        $brand = new Brand();
                        $brand->setName ($dummyProductDto->brand);
                        $brand = $this->bRepo->create($brand);
                        $result->brands_created++;
                    }
            }
            if($dummyProductDto->category === null)
                $gift->setCategoryId(null);
            else {
                $category = $this->cRepo->findByName($dummyProductDto->category);
                if($category === null)
                    {
                        $category = new Category();
                        $category->setName ($dummyProductDto->category);
                        $category->setImageUrl($this->fetchCategoryImage($dummyProductDto->category));
                        $category->setDescription(null);
                        $category->setSortOrder(0);
                        $category->setIsActive(true);
                        $category = $this->cRepo->create($category);
                        $result->categories_created++;
                    }
            }
    
            $gift->setName($dummyProductDto->title);
            $gift->setDescription($dummyProductDto->description);
            $gift->setImageUrl($dummyProductDto->thumbnail);
            $gift->setPrice($dummyProductDto->price);
            if(!($dummyProductDto->brand === null))
                $gift->setBrandId($brand->getId());
            if(!($dummyProductDto->category === null))
                $gift->setCategoryId($category->getId());
            $gift = $this->gRepo->create($gift);
            
            $result->imported++;
            }
            catch(Throwable $e) {
                $result->skipped_invalid++;
            }
        } 
        return $result;
    }
}