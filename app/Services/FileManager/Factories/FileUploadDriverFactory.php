<?php

declare(strict_types=1);

namespace App\Services\FileManager\Factories;

use App\Services\FileManager\Exceptions\FileManagerDriverNotFoundException;
use App\Services\FileManager\Interfaces\FileUploadDriverFactoryInterface;
use App\Services\FileManager\Interfaces\FileUploadManagerResolverInterface;
use EonX\EasyUtils\CollectorHelper;

final class FileUploadDriverFactory implements FileUploadDriverFactoryInterface
{
    private iterable $drivers;

    public function __construct(iterable $drivers) {
        $this->drivers = CollectorHelper::filterByClassAsArray(
            $drivers,
            FileUploadManagerResolverInterface::class
        );
    }

    /**
     * @throws FileManagerDriverNotFoundException
     */
    public function make(string $manager): FileUploadManagerResolverInterface
    {
        /** @var FileUploadManagerResolverInterface $driver */
        foreach ($this->drivers as $driver) {
            if ($driver->supports($manager) === true) {
                return $driver;
            }
        }

        throw new FileManagerDriverNotFoundException();
    }
}
