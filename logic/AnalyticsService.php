<?php

declare(strict_types=1);

class AnalyticsService
{
    private string $filePath;
    private array $data = [];

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
        $this->loadData();
    }

    private function loadData(): void
    {
        if (!file_exists($this->filePath)) {
            $this->data = [
                'pageViews' => [],
                'buttonClicks' => [],
                'createdAt' => date('Y-m-d H:i:s'),
            ];
            $this->saveData();
        } else {
            $json = file_get_contents($this->filePath);
            $decoded = json_decode($json, true);
            $this->data = is_array($decoded) ? $decoded : [];
            
            if (!isset($this->data['pageViews'])) {
                $this->data['pageViews'] = [];
            }
            if (!isset($this->data['buttonClicks'])) {
                $this->data['buttonClicks'] = [];
            }
            if (!isset($this->data['createdAt'])) {
                $this->data['createdAt'] = date('Y-m-d H:i:s');
            }
        }
    }

    public function trackPageView(string $page): void
    {
        if (!isset($this->data['pageViews'][$page])) {
            $this->data['pageViews'][$page] = 0;
        }
        $this->data['pageViews'][$page]++;
        $this->saveData();
    }

    public function trackButtonClick(string $buttonId, string $buttonText): void
    {
        $key = $buttonId ?: $buttonText;
        if (!isset($this->data['buttonClicks'][$key])) {
            $this->data['buttonClicks'][$key] = [
                'count' => 0,
                'text' => $buttonText,
            ];
        }
        $this->data['buttonClicks'][$key]['count']++;
        $this->saveData();
    }

    public function getPageViews(): array
    {
        return $this->data['pageViews'] ?? [];
    }

    public function getButtonClicks(): array
    {
        return $this->data['buttonClicks'] ?? [];
    }

    public function getCreatedAt(): string
    {
        return $this->data['createdAt'] ?? date('Y-m-d H:i:s');
    }

    public function getTotalPageViews(): int
    {
        return array_sum($this->getPageViews());
    }

    public function getTotalButtonClicks(): int
    {
        $total = 0;
        foreach ($this->getButtonClicks() as $data) {
            if (is_array($data) && isset($data['count'])) {
                $total += $data['count'];
            }
        }
        return $total;
    }

    private function saveData(): void
    {
        $json = json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        file_put_contents($this->filePath, $json);
    }
}
