<?php

namespace App\Services\FileManager\Interfaces;

use App\Services\FileManager\Exceptions\FileManagerDriverNotFoundException;

interface FileRemoverDriverFactoryInterface
{
    public function make(string $manager): FileRemoverManagerResolverInterface;
}
