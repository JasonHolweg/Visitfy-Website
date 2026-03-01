<?php

declare(strict_types=1);

final class CmsRepository
{
    private string $file;

    public function __construct(string $file)
    {
        $this->file = $file;
    }

    public function getData(): array
    {
        if (!file_exists($this->file)) {
            return [];
        }

        $raw = file_get_contents($this->file);
        if ($raw === false) {
            return [];
        }

        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function saveData(array $data): bool
    {
        $dir = dirname($this->file);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            return false;
        }

        return file_put_contents($this->file, $json . PHP_EOL, LOCK_EX) !== false;
    }
}
