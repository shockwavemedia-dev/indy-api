<?php

declare(strict_types=1);

namespace App\Services\FileManager\Interfaces;

use App\Services\FileManager\Resources\GoogleCloudConfigResource;

interface GoogleCloudConfigResolverInterface
{
    public function resolve(): GoogleCloudConfigResource;
}
