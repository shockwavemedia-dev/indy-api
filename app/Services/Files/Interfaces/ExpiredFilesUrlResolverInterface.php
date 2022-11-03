<?php

namespace App\Services\Files\Interfaces;

interface ExpiredFilesUrlResolverInterface
{
    public function resolve(): void;
}
