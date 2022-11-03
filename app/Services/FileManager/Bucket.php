<?php

declare(strict_types=1);

namespace App\Services\FileManager;

final class Bucket
{
    private string $bucket;

    private string $disk;

    public function __construct(string $bucket, string $disk) {
        $this->bucket = $bucket;
        $this->disk = $disk;
    }

    public function disk(): string
    {
        return $this->disk;
    }

    public function name(): string
    {
        return $this->bucket;
    }
}
