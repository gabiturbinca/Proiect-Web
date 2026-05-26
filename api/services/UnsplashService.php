<?php


class UnsplashService {
    private const LIMIT = 10;
    private const API_URL = 'https://api.unsplash.com/search/photos?';
    private const CACHE_TTL = 3600;
    public function __construct(
        private string $apiKey,
        private string $cacheFile
    ) {}
    public function search(string $query, int $elemNumber = self::LIMIT) : array {
        $key = $this->makeCacheKey($query, $elemNumber);
        $cached = $this->getCache($key);

        if($cached !== null)
            return $cached;
        $result = $this->fetchFromApi($query, $elemNumber);

        $dtos = array_map(fn(array $item) => $this->fetchedToDTO($item), $result['results']);
        $this->setCache($key, $dtos);

        return $dtos;
    }
    private function getCache(string $key) : ?array {
        $cache = file_exists($this->cacheFile) ? json_decode(file_get_contents($this->cacheFile), true) : [];

        if($cache === null) {
            return null;
        }
        if(!isset($cache[$key])) {
            return null;
        }

        if(time() - $cache[$key]['fetched_at'] > self::CACHE_TTL)
            return null;

        return array_map(fn($data) => new UnsplashImageDTO(
            id: $data['id'],
            urlFull: $data['urlFull'],
            urlThumb: $data['urlThumb'],
            description: $data['description'],
            authorName: $data['authorName'],
            authorUrl: $data['authorUrl'],
        )
        , $cache[ $key ]['results']);
    }
    private function setCache(string $key, array $dtos) : void {
        $cache = file_exists($this->cacheFile) ? json_decode(file_get_contents($this->cacheFile), true) : [];
        if (!is_array($cache)) 
            $cache = [];
        $cache [$key] = [
            'fetched_at' => time(),
            'results' => array_map(fn(UnsplashImageDTO $u) => $u->toArray(), $dtos),
        ];

        file_put_contents($this->cacheFile, json_encode($cache, JSON_PRETTY_PRINT));
    }
    private function fetchFromApi(string $query, int $elemNumber = self::LIMIT) : array {
        $url = self::API_URL . http_build_query([
            'query'=> $query,
            'per_page' => $elemNumber
        ]);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_HTTPHEADER , [
            'Authorization: Client-ID ' . $this->apiKey,
            'Accept-Version: v1'
        ]);

        $response = curl_exec($ch);

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);

        if($response === false || $status >= 400) {
            throw new RuntimeException("Unsplash API error: $error (status $status)");
        }

        $data = json_decode($response, true);

        if (!is_array($data) || !isset($data['results'])) 
            throw new RuntimeException("Invalid Unsplash response");
        return $data;
    }
    private function fetchedToDTO(array $photo) : UnsplashImageDTO {
        return new UnsplashImageDTO(
            id:          $photo['id'] ?? '',
            urlThumb:    $photo['urls']['small']    ?? '',
            urlFull:  $photo['urls']['regular']  ?? '',
            description: $photo['description'] ?? $photo['alt_description'] ?? '',
            authorName:  $photo['user']['name']           ?? 'Unknown',
            authorUrl:   $photo['user']['links']['html']  ?? '',
        );
    }
    private function makeCacheKey(string $query, int $elemNumber = self::LIMIT) : string {
        return sprintf('search_%s_%d', urlencode($query), $elemNumber);
    }
}