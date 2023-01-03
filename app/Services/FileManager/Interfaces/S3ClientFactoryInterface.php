<?php

namespace App\Services\FileManager\Interfaces;

use Aws\S3\S3ClientInterface;

interface S3ClientFactoryInterface
{
    public function make(): S3ClientInterface;
}
