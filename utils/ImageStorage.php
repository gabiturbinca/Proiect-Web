<?php

class ImageStorage {
    private const MAX_BYTES = 5 * 1024 * 1024;
    private const ALLOWED_MIMES = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
    ];

    private string $diskPath;
    private string $publicPath;

    public function __construct(string $diskPath, string $publicPath) {
        $this->diskPath = rtrim($diskPath, '/');
        $this->publicPath = rtrim($publicPath, '/');
    }

    public function store(array $file, int $entityId): string {
        if (($file['error'] ?? null) !== UPLOAD_ERR_OK) {
            throw new ValidationException(['image' => ['Upload failed']]);
        }
        if (($file['size'] ?? 0) > self::MAX_BYTES) {
            throw new ValidationException(['image' => ['Image must be at most 5MB']]);
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($file['tmp_name']);
        if (!isset(self::ALLOWED_MIMES[$mime])) {
            throw new ValidationException(['image' => ['Allowed types: JPEG, PNG, WebP']]);
        }
        $ext = self::ALLOWED_MIMES[$mime];

        $name = $entityId . '_' . bin2hex(random_bytes(8)) . '.' . $ext;
        $destDisk = $this->diskPath . '/' . $name;

        if (!is_dir($this->diskPath)) {
            mkdir($this->diskPath, 0755, true);
        }
        if (!move_uploaded_file($file['tmp_name'], $destDisk)) {
            throw new RuntimeException("Failed to move uploaded file");
        }

        return $this->publicPath . '/' . $name;
    }

    public function delete(?string $publicUrl): void {
        if ($publicUrl === null || $publicUrl === '') return;
        if (!str_starts_with($publicUrl, $this->publicPath . '/')) return;

        $name = basename($publicUrl);
        $disk = $this->diskPath . '/' . $name;
        if (is_file($disk)) {
            @unlink($disk);
        }
    }
}
