<?php

namespace App\Services\FileManager\Interfaces;

interface FileManagerConfigResolverInterface
{
    public function resolve(): array;
}
