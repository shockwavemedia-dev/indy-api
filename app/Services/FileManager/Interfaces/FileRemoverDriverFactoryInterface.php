<?php

namespace App\Services\FileManager\Interfaces;

interface FileRemoverDriverFactoryInterface
{
    public function make(string $manager): FileRemoverManagerResolverInterface;
}
