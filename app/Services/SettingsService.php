<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class SettingsService
{
    protected string $path = 'private/settings.json';
    protected array $data = [];

    public function __construct()
    {
        $this->load();
    }

    protected function load(): void
    {
        if (Storage::disk('local')->exists($this->path)) {
            $content = Storage::disk('local')->get($this->path);
            $decoded = json_decode($content, true);
            $this->data = is_array($decoded) ? $decoded : [];
        } else {
            $this->data = [];
        }
    }

    protected function persist(): void
    {
        // ensure directory exists
        $dir = dirname($this->path);
        if (! Storage::disk('local')->exists($dir)) {
            Storage::disk('local')->makeDirectory($dir);
        }

        Storage::disk('local')->put($this->path, json_encode($this->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    public function all(): array
    {
        return $this->data;
    }

    public function get(string $key, $default = null)
    {
        return $this->data[$key] ?? $default;
    }

    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
        $this->persist();
    }

    public function setMany(array $values): void
    {
        foreach ($values as $k => $v) {
            $this->data[$k] = $v;
        }
        $this->persist();
    }
}
