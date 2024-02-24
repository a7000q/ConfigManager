<?php

declare(strict_types=1);

namespace RailMukhametshin\ConfigManager;

use Exception;

class ConfigManager
{
    protected array $configurations = [];

    /**
     * @throws Exception
     */
    public function load(string $filePath): void
    {
        $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

        $configurations = match ($fileExtension) {
            'php' => require $filePath,
            'json' => json_decode(file_get_contents($filePath), true),
            default => throw new Exception('Config file extension is invalid!'),
        };

        $this->configurations = array_merge($this->configurations, $configurations);
    }

    public function get($key, $default = null): mixed
    {
        return $this->configurations[$key] ?? $default;
    }

    public function set($key, $value): void
    {
        $this->configurations[$key] = $value;
    }
}